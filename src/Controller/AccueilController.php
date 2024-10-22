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
            $this->reviews = $data['member'];
        }

        return $this->reviews;
    }

    private function getAllUsers(): array
    {
        if (!$this->users) {
            $response = $this->httpClient->request('GET', 'http://127.0.0.1:8001/api/users', [
                'verify_peer' => false,
            ]);
            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                throw new \Exception('Error getting all users.');
            }
            $data = $response->toArray();
            $this->users = $data['member'];
        }

        return $this->users;
    }

    private function mapReviewsToUsers(array $reviews, array $users): array
    {
        foreach ($reviews as &$review) {
            // Si la clé 'user' existe, on la récup et on en extrait l'ID de l'utilisateur depuis l'URI
            if (isset($review['user'])) {
                // On extrait l'ID utilisateur de l'URI ("/api/users/2" => "2")
                $userId = intval(basename($review['user']));
    
                foreach ($users as $user) {
                    if ($user['id'] === $userId) { // Si l'ID utilisateur extrait == l'ID des utilisateurs
                        $review['user_name'] = $user['firstname']; // On match le prénom de l'utilisateur à son avis
                        break;
                    }
                }
            } else {
                // Si jamais 'user' n'existe pas => "Utilisateur inconnu"
                $review['user_name'] = 'Utilisateur inconnu';
            }
        }
        return $reviews;
    }


    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
        $reviews = $this->mapReviewsToUsers($this->getAllReviews(), $this->getAllUsers());
    
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'reviews' => $reviews,  // On passe TOUS les avis ici
        ]);
    }

}
