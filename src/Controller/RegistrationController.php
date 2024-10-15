<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class RegistrationController extends AbstractController
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
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            //envoie le datetime, transformé au fuseau horaire de paris
            $user->setCreatedAt(date_create($datetime = 'now', new DateTimeZone('Europe/Paris')));
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_api_index');
        }


        $users = $this->getAllUsers();

        $filtered_users = $users;
        $userPick = rand(0, count($filtered_users) - 1);
        
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
            'users' => $filtered_users,
            'userPick' => $userPick
        ]);
    }
}