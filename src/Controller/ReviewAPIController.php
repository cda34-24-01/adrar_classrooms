<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ReviewAPIController extends AbstractController
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
            $response = $this->httpClient->request('GET', 'https://127.0.0.1:8001/api/reviews', [
                'verify_peer' => false,
            ]);
            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                throw new \Exception('Error getting all reviews.');
            }
            $data = $response->toArray();
            $reviews = $data['member'];

            foreach ($reviews as &$review) {
                $reviewUsers = $review['user'];
                $reviewContent = $review['content'];

                foreach ($reviewUsers as $reviewUser) {
                    $parts = explode('/', $reviewUser);
                    $reviewContent[] = end($parts);
                }

                $reviews['reviewContent'] = $reviewContent;
            }

            $this->reviews = $reviews;
        }

        return $this->reviews;
    }
    private function getUsersWithReviews(): array
    {
        $users = [];

        if (!$this->users) {
            $response = $this->httpClient->request('GET', 'https://127.0.0.1:8001/api/users', [
                'verify_peer' => false,
            ]);
            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                throw new \Exception('Error getting all users.');
            }

            $data = $response->toArray();

            foreach ($data['member'] as $user) {
                if (isset($user['reviews']) && count($user['reviews']) > 0) {
                    $users[] = $user;
                }
            }

            $this->users = $users;
        }

        return $this->users;
    }

    #[Route('/review', name: 'app_review')]
    public function index(Request $request): Response
    {
        $reviews = $this->getAllReviews();
        $users = $this->getUsersWithReviews();

        return $this->render('review_api/index.html.twig', [
            'controller_name' => 'ReviewAPIController',
            'reviews' => $reviews,
            'languages' => $users,
        ]);
    }


}
