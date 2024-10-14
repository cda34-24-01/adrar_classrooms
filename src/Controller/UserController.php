<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_list')]
    public function index(UserRepository $userRepository): Response
    {
        // Récupère tous les utilisateurs
        $users = $userRepository->findAll();

        // Retourne une réponse, par exemple en affichant les utilisateurs dans une vue
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/{id}', name: 'user_show')]
    public function show(UserRepository $userRepository, int $id): Response
    {
        // Récupère un utilisateur par son identifiant
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('L\'utilisateur n\'existe pas.');
        }

        // Retourne une réponse, par exemple en affichant les informations de l'utilisateur dans une vue
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/email/{email}', name: 'user_by_email')]
    public function showByEmail(string $email, UserRepository $userRepository): Response
    {
        // Récupérer un utilisateur par son email
        $user = $userRepository->findOneBy(['email' => $email]);

        // Si l'utilisateur n'existe pas
        if (!$user) {
            throw $this->createNotFoundException('L\'utilisateur avec cet email n\'existe pas.');
        }

        // Retourner l'utilisateur à une vue Twig
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/username/{username}', name: 'user_by_username')]
    public function showByUsername(string $username, UserRepository $userRepository): Response
    {
        // Récupérer un utilisateur par son nom d'utilisateur
        $user = $userRepository->findOneBy(['username' => $username]);

        // Si l'utilisateur n'existe pas
        if (!$user) {
            throw $this->createNotFoundException('L\'utilisateur avec ce nom d\'utilisateur n\'existe pas.');
        }

        // Retourner l'utilisateur à une vue Twig
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
}
