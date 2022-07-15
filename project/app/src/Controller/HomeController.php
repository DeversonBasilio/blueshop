<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoriaRepository;
use App\Repository\ProdutoRepository;
use App\Entity\Produto;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ProdutoRepository $produtoRepository, CategoriaRepository $categoriaRepository,Request $request): Response
    {
        ## Pega a sessão
        $session= $request->getSession();

        #carrega os produtos da sessão
        $products = $session->get('products', []);

        $termo_busca = $request->query->get('busca_produto');

        $categorias = [];
        $produtos = [];

        if(is_null($termo_busca)) {
            $produtos = $produtoRepository->findAll();            
        } else {
            $produtos = $produtoRepository->findByNome($termo_busca);    
        }

        return $this->render('home/index.html.twig', [
            'produtos' => $produtos,
            'categorias' => $categorias = $categoriaRepository->findAll(),
            'qtd_carrinho'=> count($products),
        ]);
    }

    #[Route('/home/{id}',name:"add_prod_item")]
    public function add(Produto $produto, Request $request,ProdutoRepository $produtoRepository, CategoriaRepository $categoriaRepository): Response
    {
        ## Pega a sessão
        $session= $request->getSession();

        #carrega os produtos da sessão
        $products = $session->get('products', []);

        #inclui o produto na posição do ID dentro do array.
        $quantidade = isset($products[$produto->getId()]["quantidade"])? $products[$produto->getId()]['quantidade']:0;
        
        $quantidade += 1;
        $products[$produto->getId()] =array("produto"=>$produto,"quantidade"=>$quantidade);

        #carrega a lista dentro da sessão 
        $session->set('products', $products);
        
        $this->addFlash('success', 'add');
        
        return $this->redirectToRoute('app_home');
    }

    #[Route('/carrinho', name: 'app_carrinho')]
    public function carrinho(ProdutoRepository $produtoRepository,Request $request): Response
    {
        ## Pega a sessão
        $session= $request->getSession();

        #carrega os produtos da sessão
        $products = $session->get('products', []);

        return $this->render('home/carrinho.html.twig', [
            'produtos' => $products,
            'qtd_carrinho'=> count($products),
        ]);
    }

    #[Route('/carrinho/edita', name: 'app_carrinho_edita', methods: ['POST'])]
    public function carrinho_edita(ProdutoRepository $produtoRepository,Request $request): Response
    {
      ## Pega a sessão
      $session = $request->getSession();
      $ProdId  = $request->request->get('ProdId');
      $Quant   = $request->request->get('Quantidade');

      $products = $session->get('products', []);
      
      if($Quant <= 0) {
        unset($products[$ProdId]);
      } else {
        $products[$ProdId] =array("produto"=>$products[$ProdId]["produto"],
                                            "quantidade"=>$Quant);
      }
      
      #carrega a lista dentro da sessão 
      $session->set('products', $products);
      
      $this->addFlash('success', 'add');
      
      return $this->redirectToRoute('app_carrinho');
    }   
}
