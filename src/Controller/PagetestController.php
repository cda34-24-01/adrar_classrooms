<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PagetestController extends AbstractController
{
    #[Route('/pagetest', name: 'app_pagetest')]
    public function index(): Response
    {
        return $this->render('pagetest/index.html.twig', [
            'controller_name' => 'PagetestController',
        ]);
    }
}
