<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SecurityController extends AbstractController
{
    private $httpClient;
    private $users;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    private function getAllUsers(): array
    {
        if (!$this->users) {
            $response = $this->httpClient->request('GET', 'https://127.0.0.1:8001/api/users', [
                'verify_peer' => false,
            ]);
            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                throw new \Exception('Error getting all users.');
            }
            $data = $response->toArray();
            $users = $data['member'];

            $this->users = $users;
        }

        return $this->users;
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $users = $this->getAllUsers();

        $filtered_users = $users;
        $userPick = rand(0, count($filtered_users) - 1);

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'users' => $filtered_users,
            'userPick' => $userPick
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
