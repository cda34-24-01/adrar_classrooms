<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AccueilController extends AbstractController
{

    private $httpClient;
    private $reviews;
    private $users;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    private function getAllReviews(): array
    {
        if (!$this->reviews) {
            $response = $this->httpClient->request('GET', 'http://127.0.0.1:8001/api/reviews', [
                'verify_peer' => false,
            ]);
            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                throw new \Exception('Error getting all reviews.');
            }
            $data = $response->toArray();
            $reviews = $data['member'];

            $this->reviews = $reviews;
        }

        return $this->reviews;
    }
    private function getAllUsers(): array
    {
        $users = [];

        if (!$this->users) {
            $response = $this->httpClient->request('GET', 'http://127.0.0.1:8001/api/users', [
                'verify_peer' => false,
            ]);
            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                throw new \Exception('Error getting all users.');
            }

            $data = $response->toArray();
            $users = $data['member'];

            // foreach ($data['member'] as $user) {
            //     if (isset($user['reviews']) && count($user['reviews']) > 0) {
            //         $users[] = $user;
            //     }
            // }

            $this->users = $users;

        }

        return $this->users;
    }

    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
        $reviews = $this->getAllReviews();
        $users = $this->getAllUsers();
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'reviews' => $reviews,
            'users' => $users,
        ]);
    }



}



