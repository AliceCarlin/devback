<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Slugify;

class DemoController extends AbstractController
{
    #[Route('/demo', name: 'app_demo')]
    public function index(): Response
    {
        $slug = new Slugify();
        $demo = $slug->slugify('CLIQUE ICI POUR GAGNER DES ROBUX');

        return $this->render('demo/index.html.twig', [
            'controller_name' => 'DemoController',
            date_default_timezone_set('Europe/Paris'),
            'time' => date('H:i:s, \l\e d/m/Y'),
            'demo' => $demo,
        ]);

    }
}
