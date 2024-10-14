<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LanguagesController extends AbstractController
{
    #[Route('/languages', name: 'app_languages')]
    public function index(): Response
    {
        return $this->render('languages/index.html.twig', [
            'controller_name' => 'LanguagesController',
        ]);
    }
}
