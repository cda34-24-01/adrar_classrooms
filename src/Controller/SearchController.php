<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'search', methods: ['GET'])]

    private HttpClientInterface $httpClient;
    public function search(Request $request): JsonResponse
    {
        $query = $request->query->get('q');
        $suggestions = [];

        if ($query) {
            try {
                // Appel à l'API externe
                $response = $this->httpClient->request('GET', 'http://127.0.0.1:8000/api/languages', [
                    'query' => ['q' => $query]
                ]);

                // Vérification du statut de la réponse
                if ($response->getStatusCode() === 200) {
                    $suggestions = $response->toArray(); // Convertir la réponse JSON en tableau
                }
            } catch (\Exception $e) {
                // Gérer les erreurs d'appel à l'API
                return new JsonResponse(['error' => 'Erreur lors de la récupération des suggestions.'], 500);
            }
        }

        return new JsonResponse($suggestions);
    }
}
