<?php

namespace App\Controller;

use App\Entity\Pedido;
use App\Entity\PedidoItens;
use App\Entity\Produto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PedidoRepository;
use App\Repository\PedidoItensRepository;
use App\Repository\ProdutoRepository;
use Doctrine\ORM\EntityManagerInterface;

class PedidoController extends AbstractController
{
    #[Route('/pedidosgerais', name: 'app_pedido')]
    public function index(PedidoRepository $pedidoRepository): Response
    {
        return $this->render('pedido/index.html.twig', [
            'controller_name' => 'PedidoController',
            'pedidos' => $pedidoRepository->findAll(),
        ]);
    }

    #[Route('/pedido/novo', name: 'app_pedido_add')]
    public function novo_pedido(Request $request,
                                PedidoRepository $pedidoRepository,
                                ProdutoRepository $produtoRepository,
                                EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
                
        $session= $request->getSession();

        $usuario  = $this->getUser();
        $products = $session->get('products', []);

        $pedido = new Pedido();
        $pedido->setUsuario($usuario);
        $pedido->setDataCriado(new \DateTime());
        $pedido->setStatus('Aberto');

        $total_pedido = 0;
        
        foreach ($products as $key => $item_carrinho){

            $item = new PedidoItens();
            $produto = new Produto();

            $produto = $produtoRepository->findOneById($item_carrinho["produto"]->getId());
            $total_item = $item_carrinho["quantidade"] * $item_carrinho["produto"]->getPreco();
            $item->setProduto($produto);
            $item->setQuantidade($item_carrinho["quantidade"]);
            $item->setTotal($total_item);

            $total_pedido += $total_item;            

            $pedido->addPedidoIten($item);
            $item->setPedido($pedido);

            $entityManager->persist( $item);
        }
        $pedido->setTotal($total_pedido);

        $entityManager->persist($pedido);
        $entityManager->flush();      
        $session->set('products', []);

        return $this->redirectToRoute('app_pedido_edit', ["id" => $pedido->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/pedido/edit/{id}', name: 'app_pedido_edit')]
    public function edita_pedido(Request $request,int $id, PedidoRepository $pedidoRepository): Response
    {        
        $pedido = $pedidoRepository->findOneById($id);
        $pedido->getPedidoItens();
        $pedido->getUsuario();

        return $this->render('pedido/edit.html.twig', [
            'pedido' => $pedido,
            'qtd_carrinho'=> 0
        ]);
    }

    #[Route('/pedido/show/{id}', name: 'app_pedido_show')]
    public function show_pedido(Request $request,int $id, PedidoRepository $pedidoRepository): Response
    {        
        $pedido = $pedidoRepository->findOneById($id);
        $pedido->getPedidoItens();
        $pedido->getUsuario();

        return $this->render('pedido/show.html.twig', [
            'pedido' => $pedido,
            'qtd_carrinho'=> 0
        ]);
    }
    
    #[Route('/pedido/finaliza', name: 'app_fecha_pedido')]
    public function fecha_pedido(Request $request,
                                PedidoRepository $pedidoRepository,
                                EntityManagerInterface $entityManager): Response
    {
        
        $pedido_id = $request->request->get('pedido_id');

        $pedido = $pedidoRepository->findOneById($pedido_id);

        if($pedido->getStatus() == 'Aberto') {
            $nome      = $request->request->get('nome');
            $rua       = $request->request->get('rua');
            $bairro    = $request->request->get('bairro');
            $cidade    = $request->request->get('cidade');
            $pais      = $request->request->get('pais');
            $cep       = $request->request->get('cep');
            
            $pedido->getUsuario()->setNome($nome);
            $pedido->getUsuario()->setRua($rua);
            $pedido->getUsuario()->setBairro($bairro);
            $pedido->getUsuario()->setCidade($cidade);
            $pedido->getUsuario()->setPais($pais);
            $pedido->getUsuario()->setCep($cep);
            $pedido->setStatus('Finalizado');
            
            $entityManager->persist($pedido);
            $entityManager->flush();      
        }
        
        return $this->redirectToRoute('app_pedido_edit', ["id" => $pedido_id], Response::HTTP_SEE_OTHER);
    }

    #[Route('/pedido/item/edita', name: 'app_pedidositens_edita')]
    public function PedidoItensEdit(PedidoRepository $pedidoRepository,
                                    PedidoItensRepository $pedidoItensRepository,
                                    EntityManagerInterface $entityManager,
                                    Request $request): Response
    {
      ## Pega a sessão
      $session = $request->getSession();

      $PedidoItemId  = $request->request->get('PedidoItemId');
      $Quant   = $request->request->get('Quantidade');
        
      $PedidoItem = $pedidoItensRepository->findOneById($PedidoItemId);
      $pedido_id = $PedidoItem->getPedido()->getId();

      if($Quant <= 0) {
        
        if( $PedidoItem->getPedido()->contaItens() > 1) {
            $entityManager->remove($PedidoItem);
            $entityManager->flush(); 
        }       
      } else {
        $PedidoItem->setQuantidade($Quant);
        $total = $PedidoItem->getProduto()->getPreco() * $Quant;
        $PedidoItem->setTotal($total);
        $entityManager->persist($PedidoItem);        
        $entityManager->flush(); 
      }
      
      $pedido = $pedidoRepository->findOneById($pedido_id);
      $pedido->calculaTotalItens();

      $entityManager->persist($pedido);     
      $entityManager->flush();        
      
      return $this->redirectToRoute('app_pedido_edit', ["id" => $pedido_id], Response::HTTP_SEE_OTHER);
    } 
}
