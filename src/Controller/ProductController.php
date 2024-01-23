<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
    
    #[Route('/product', name: 'app_product')]
    public function listProducts()
    {
        return $this->render('product/index.html.twig',[
            'title' => "Liste des Produits",
        ]);

    }

    #[Route('/product/{id}', name: 'product_view')]
    public function viewProduct(Request $request)
    {
        // Récupère la valeur de l'ID à partir de la requête GET
        $id = $request->query->get('id');
    
        return $this->render('product/index.html.twig', [
            'title' => 'Affichage du produit ' . $id,
        ]);
    }
}
