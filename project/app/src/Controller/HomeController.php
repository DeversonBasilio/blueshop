<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoriaRepository;
use App\Repository\ProdutoRepository;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ProdutoRepository $produtoRepository, CategoriaRepository $categoriaRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'produtos' => $produtoRepository->findAll(),
            'categorias' => $categoriaRepository->findAll(),
        ]);
    }
}
