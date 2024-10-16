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
            // Vérifie que la clé 'user' existe dans l'avis et extraire l'ID utilisateur depuis l'URI
            if (isset($review['user'])) {
                // Extraire l'ID utilisateur de l'URI (par exemple, "/api/users/2" devient "2")
                $userId = intval(basename($review['user']));
    
                foreach ($users as $user) {
                    if ($user['id'] === $userId) { // Compare l'ID utilisateur extrait avec l'ID des utilisateurs
                        $review['user_name'] = $user['firstname']; // Ajoute le prénom de l'utilisateur à l'avis
                        break;
                    }
                }
            } else {
                // Gère le cas où 'user' n'existe pas (par exemple, afficher "Utilisateur inconnu")
                $review['user_name'] = 'Utilisateur inconnu';
            }
        }
        return $reviews;
    }

    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
        $reviews = $this->getAllReviews();
        $users = $this->getAllUsers();
        
        // Associe les utilisateurs aux avis
        $reviewsWithUserNames = $this->mapReviewsToUsers($reviews, $users);

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'reviews' => $reviewsWithUserNames,
        ]);
    }

}
