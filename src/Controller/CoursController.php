<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoursController extends AbstractController
{
    private $httpClient;
    private $courses;
    private $languages;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    private function getAllCourses(): array
    {
        if (!$this->courses) {
            $response = $this->httpClient->request('GET', 'https://127.0.0.1:8001/api/cours', [
                'verify_peer' => false,
            ]);
            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                throw new \Exception('Error getting all courses.');
            }
            $data = $response->toArray();
            $courses = $data['member'];

            foreach ($courses as &$course) {
                $chapterUrls = $course['chapter'];
                $chapterIds = [];

                foreach ($chapterUrls as $chapterUrl) {
                    $parts = explode('/', $chapterUrl);
                    $chapterIds[] = end($parts);
                }

                $course['chaptersIds'] = $chapterIds;
            }

            $this->courses = $courses;
        }

        return $this->courses;
    }
    private function getCourseById(int $id): array
    {
        try {
            $response = $this->httpClient->request('GET', 'https://127.0.0.1:8001/api/cours/' . $id, [
                'verify_peer' => false,
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode !== 200) {
                throw new \Exception('Error getting course by id.');
            }

            $data = $response->toArray();

            return $data;
        } catch (\Exception $e) {
            dump('Error: ' . $e->getMessage());
        }
    }
    private function getLanguagesWithCourses(): array
    {
        $languages = [];

        if (!$this->languages) {
            $response = $this->httpClient->request('GET', 'https://127.0.0.1:8001/api/languages', [
                'verify_peer' => false,
            ]);
            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                throw new \Exception('Error getting all languages.');
            }

            $data = $response->toArray();

            foreach ($data['member'] as $language) {
                if (isset($language['cours']) && count($language['cours']) > 0) {
                    $languages[] = $language;
                }
            }

            $this->languages = $languages;
        }

        return $this->languages;
    }
    private function getCoursesByLanguage($language): array
    {
        $courses = [];

        foreach ($language['cours'] as $courseUrl) {
            try {
                $response = $this->httpClient->request('GET', 'https://127.0.0.1:8001' . $courseUrl, [
                    'verify_peer' => false,
                ]);

                $statusCode = $response->getStatusCode();

                if ($statusCode !== 200) {
                    throw new \Exception('Error getting courses by language.');
                }

                $data = $response->toArray();

                $chapterUrls = $data['chapter'];
                $chapterIds = [];

                foreach ($chapterUrls as $chapterUrl) {
                    $parts = explode('/', $chapterUrl);
                    $chapterIds[] = end($parts);
                }

                $data['chaptersIds'] = $chapterIds;

                $courses[] = $data;
            } catch (\Exception $e) {
                dump('Error: ' . $e->getMessage());
            }
        }

        return $courses;
    }
    private function getChaptersByCourse($chaptersUrls): array
    {
        $chapters = [];
        foreach ($chaptersUrls as $chapterUrl) {
            try {
                $response = $this->httpClient->request('GET', 'https://127.0.0.1:8001' . $chapterUrl, [
                    'verify_peer' => false,
                ]);
                $statusCode = $response->getStatusCode();
                if ($statusCode !== 200) {
                    throw new \Exception('Error getting chapters by course.');
                }
                $data = $response->toArray();
                $chapters[] = $data;
            } catch (\Exception $e) {
                dump('Error: ' . $e->getMessage());
            }
        }
        return $chapters;
    }
    private function getChapterById($chapterId): array
    {
        try {
            $response = $this->httpClient->request('GET', 'https://127.0.0.1:8001/api/chapters/' . $chapterId, [
                'verify_peer' => false,
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode !== 200) {
                throw new \Exception('Error getting chapter by id.');
            }

            $data = $response->toArray();

            return $data;
        } catch (\Exception $e) {
            dump('Error: ' . $e->getMessage());
        }
    }

    #[Route('/cours', name: 'app_cours')]
    public function index(Request $request): Response
    {
        $courses = $this->getAllCourses();
        $languages = $this->getLanguagesWithCourses();

        $selected_language_title = $request->query->get('language');

        $selected_language = null;
        foreach ($languages as $language) {
            if ($language['title'] === $selected_language_title) {
                $selected_language = $language;
                break;
            }
        }

        $filtered_courses = $courses;

        if ($selected_language) {
            $filtered_courses = $this->getCoursesByLanguage($selected_language);
        }


        return $this->render('cours/index.html.twig', [
            'controller_name' => 'CoursController',
            'courses' => $filtered_courses,
            'languages' => $languages,
            'selected_language' => $selected_language,
        ]);
    }

    #[Route('/cours/{courseId}/{chapterId}', name: 'app_chapter_show', methods: ['GET'])]
    public function show_chapter($courseId, $chapterId): Response
    {

        $selectedCourse = $this->getCourseById($courseId);
        if (!$selectedCourse) {
            throw $this->createNotFoundException('Course not found.');
        }

        $chapters = $this->getChaptersByCourse($selectedCourse['chapter']);
        if (!$chapters) {
            $chapters = [];
        }

        $selectedCourse['chapter'] = $chapters;

        $currentChapter = null;
        if ($chapterId !== 'noChapters') {
            $currentChapter = $this->getChapterById($chapterId);
        }

        $chapterCount = count($chapters);
        $currentIndex = array_search($chapterId, array_column($chapters, 'id'));

        $previousChapter = ($currentIndex > 0) ? $chapters[$currentIndex - 1] : null;
        $nextChapter = ($currentIndex < $chapterCount - 1) ? $chapters[$currentIndex + 1] : null;

        return $this->render('cours/show_course.html.twig', [
            'course' => $selectedCourse,
            'chapters' => $chapters,
            'chapter' => $currentChapter,
            'previousChapter' => $previousChapter,
            'nextChapter' => $nextChapter,
        ]);
    }
}
