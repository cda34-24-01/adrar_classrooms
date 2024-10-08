<?php

namespace App\Controller;

use App\Entity\Chapters;
use App\Entity\Courses;
use App\Form\ChaptersType;
use App\Repository\ChaptersRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chapters')]
final class ChaptersController extends AbstractController
{
    #[Route(name: 'app_all_chapters', methods: ['GET'])]
    public function index(ChaptersRepository $chaptersRepository): Response
    {
        return $this->render('chapters/list_chapters.html.twig', [
            'chapters' => $chaptersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_chapters_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $chapter = new Chapters();
        $form = $this->createForm(ChaptersType::class, $chapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chapter);
            $entityManager->flush();

            return $this->redirectToRoute('app_all_chapters', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chapters/new.html.twig', [
            'chapter' => $chapter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chapter_show', methods: ['GET'])]
    public function show(Chapters $chapter): Response
    {

        return $this->render('chapters/show.html.twig', [
            'chapter' => $chapter,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_chapters_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chapters $chapter, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChaptersType::class, $chapter);
        $form->handleRequest($request);
        // Définit la date actuelle par défaut
        $chapter->setPostedAt(new DateTime());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_chapters_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chapters/edit.html.twig', [
            'chapter' => $chapter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chapters_delete', methods: ['POST'])]
    public function delete(Request $request, Chapters $chapter, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $chapter->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($chapter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_chapters_index', [], Response::HTTP_SEE_OTHER);
    }
}
