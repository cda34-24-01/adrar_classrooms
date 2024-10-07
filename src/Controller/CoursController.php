<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoursController extends AbstractController
{
    private array $courses = [
        [
            'id' => 1,
            'title' => 'C++ Fundamentals',
            'description' => 'This course is for beginners in C++. It focuses on basic syntax and control flow structures. Basic concepts of objects and classes are also covered.',
            'chapters' => [
                [
                    'id' => 1,
                    'title' => 'Introduction to C++',
                    'description' => 'This chapter introduces the basics of C++, including syntax and simple programs.',
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin id viverra lacus...',
                    'validated' => true,
                ],
                [
                    'id' => 2,
                    'title' => 'Control Flow in C++',
                    'description' => 'In this chapter, we cover control flow structures like loops and conditionals.',
                    'content' => 'lorem ipsum',
                    'validated' => false,
                ],
                [
                    'id' => 3,
                    'title' => 'Classes and Objects in C++',
                    'description' => 'This chapter introduces basic object-oriented concepts in C++.',
                    'content' => 'lorem ipsum',
                    'validated' => false,
                ],
            ],
            'level' => 'Beginner',
            'estimated_time' => '3hrs',
            'created_at' => '2022-05-01',
            'updated_at' => '2022-05-02',
            'language' => 'C++',
            'image' => null,
            'files' => [
                'https://www.learncpp.com/',
                'https://www.tutorialspoint.com/cplusplus/',
            ],
            'validated' => false,
        ],
        [
            'id' => 2,
            'title' => 'JavaScript Basics',
            'description' => 'An introductory course on JavaScript. Learn how to add interactivity to your website by using JavaScript for DOM manipulation and event handling.',
            'chapters' => [
                [
                    'id' => 1,
                    'title' => 'Introduction to JavaScript',
                    'description' => 'An introduction to JavaScript programming, syntax, and basic functions.',
                    'content' => 'Lorem ipsum dolor sit amet...',
                    'validated' => true,
                ],
                [
                    'id' => 2,
                    'title' => 'DOM Manipulation',
                    'description' => 'Learn how to manipulate the DOM to make interactive websites.',
                    'content' => 'lorem ipsum',
                    'validated' => false,
                ],
                [
                    'id' => 3,
                    'title' => 'Event Handling',
                    'description' => 'This chapter explains how to handle user interactions with events in JavaScript.',
                    'content' => 'lorem ipsum',
                    'validated' => false,
                ],
            ],
            'level' => 'Beginner',
            'estimated_time' => '2.5hrs',
            'created_at' => '2022-06-01',
            'updated_at' => '2022-06-10',
            'language' => 'JavaScript',
            'image' => 'https://www.freecodecamp.org/news/content/images/2022/06/javascript-logo.png',
            'files' => [
                'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide',
                'https://www.javascript.com/learn',
            ],
            'validated' => true,
        ],
        [
            'id' => 3,
            'title' => 'Python for Data Science',
            'description' => 'The course covers Python syntax, working with data structures like lists and dictionaries, and using libraries to manipulate and visualize data.',
            'chapters' => [
                [
                    'id' => 1,
                    'title' => 'Introduction to Python for Data Science',
                    'description' => 'Learn Python basics and how to set up your data science environment.',
                    'content' => 'Lorem ipsum dolor sit amet...',
                    'validated' => true,
                ],
                [
                    'id' => 2,
                    'title' => 'Data Manipulation with Pandas',
                    'description' => 'In this chapter, we explore how to manipulate data using the Pandas library.',
                    'content' => 'lorem ipsum',
                    'validated' => false,
                ],
                [
                    'id' => 3,
                    'title' => 'Data Visualization with Matplotlib',
                    'description' => 'This chapter covers data visualization techniques with Matplotlib.',
                    'content' => 'lorem ipsum',
                    'validated' => false,
                ],
            ],
            'level' => 'Intermediate',
            'estimated_time' => '4hrs',
            'created_at' => '2022-03-15',
            'updated_at' => '2022-03-20',
            'language' => 'Python',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c3/Python-logo-notext.svg/1200px-Python-logo-notext.svg.png',
            'files' => [
                'https://numpy.org/',
                'https://pandas.pydata.org/',
            ],
            'validated' => true,
        ],
        [
            'id' => 4,
            'title' => 'Advanced Java Programming',
            'description' => 'A comprehensive course for learning advanced Java concepts, including multi-threading, concurrency, and Java Streams API.',
            'chapters' => [
                [
                    'id' => 1,
                    'title' => 'Advanced Java Introduction',
                    'description' => 'This chapter introduces advanced Java concepts and sets up the environment.',
                    'content' => 'Lorem ipsum dolor sit amet...',
                    'validated' => true,
                ],
                [
                    'id' => 2,
                    'title' => 'Multi-threading in Java',
                    'description' => 'Learn about Java multi-threading and concurrency.',
                    'content' => 'lorem ipsum',
                    'validated' => false,
                ],
                [
                    'id' => 3,
                    'title' => 'Java Streams API',
                    'description' => 'This chapter covers the Java Streams API for handling data streams efficiently.',
                    'content' => 'lorem ipsum',
                    'validated' => false,
                ],
            ],
            'level' => 'Advanced',
            'estimated_time' => '5hrs',
            'created_at' => '2022-04-05',
            'updated_at' => '2022-04-08',
            'language' => 'Java',
            'image' => null,
            'files' => [
                'https://www.javatpoint.com/java-tutorial',
                'https://docs.oracle.com/javase/tutorial/',
            ],
            'validated' => false,
        ],
        [
            'id' => 5,
            'title' => 'Web Development with PHP',
            'description' => 'This course covers the basics of web development using PHP. Learn how to create dynamic websites and interact with databases.',
            'chapters' => [
                [
                    'id' => 1,
                    'title' => 'Introduction to PHP',
                    'description' => 'An introduction to web development using PHP.',
                    'content' => 'Lorem ipsum dolor sit amet...',
                    'validated' => true,
                ],
                [
                    'id' => 2,
                    'title' => 'PHP and MySQL',
                    'description' => 'Learn how to use PHP to interact with MySQL databases.',
                    'content' => 'lorem ipsum',
                    'validated' => false,
                ],
                [
                    'id' => 3,
                    'title' => 'Creating Dynamic Websites',
                    'description' => 'This chapter explains how to create dynamic content using PHP.',
                    'content' => 'lorem ipsum',
                    'validated' => false,
                ],
            ],
            'level' => 'Beginner',
            'estimated_time' => '3hrs',
            'created_at' => '2022-07-01',
            'updated_at' => '2022-07-05',
            'language' => 'PHP',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/20/PHP-logo.svg/1200px-PHP-logo.svg.png',
            'files' => [
                'https://www.php.net/manual/en/tutorial.php',
                'https://www.w3schools.com/php/',
            ],
            'validated' => true,
        ],
        [
            'id' => 6,
            'title' => 'SQL for Beginners',
            'description' => 'An introductory course to SQL, focusing on querying databases, creating tables, and managing relationships between data.',
            'chapters' => [
                [
                    'id' => 1,
                    'title' => 'Introduction to SQL',
                    'description' => 'Learn the basics of SQL and querying databases.',
                    'content' => 'Lorem ipsum dolor sit amet...',
                    'validated' => true,
                ],
                [
                    'id' => 2,
                    'title' => 'Creating Tables in SQL',
                    'description' => 'This chapter explains how to create and manage tables in SQL.',
                    'content' => 'lorem ipsum',
                    'validated' => false,
                ],
                [
                    'id' => 3,
                    'title' => 'Managing Data Relationships',
                    'description' => 'Learn how to manage relationships between different sets of data in SQL.',
                    'content' => 'lorem ipsum',
                    'validated' => false,
                ],
            ],
            'level' => 'Beginner',
            'estimated_time' => '2hrs',
            'created_at' => '2022-07-01',
            'updated_at' => '2022-07-05',
            'language' => 'PHP',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/20/PHP-logo.svg/1200px-PHP-logo.svg.png',
            'files' => [
                'https://www.php.net/manual/en/tutorial.php',
                'https://www.w3schools.com/php/',
            ],
            'validated' => true,
        ],
    ];

    #[Route('/cours', name: 'app_cours')]
    public function index(Request $request): Response
    {

        $selected_language = $request->query->get('language');

        $filtered_courses = $this->courses;

        if ($selected_language) {
            $filtered_courses = array_filter($filtered_courses, function ($course) use ($selected_language) {
                return $course['language'] === $selected_language;
            });
        }

        $languages = array_unique(array_column($this->courses, 'language'));

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
        $selectedCourse = null;
        foreach ($this->courses as $course) {
            if ($course['id'] == $courseId) {
                $selectedCourse = $course;
                break;
            }
        }

        if (!$selectedCourse) {
            throw $this->createNotFoundException('Course not found.');
        }

        $currentChapter = null;
        foreach ($selectedCourse['chapters'] as $chapter) {
            if ($chapter['id'] == $chapterId) {
                $currentChapter = $chapter;
                break;
            }
        }

        if (!$currentChapter) {
            throw $this->createNotFoundException('Chapter not found.');
        }

        $chapterCount = count($selectedCourse['chapters']);
        $currentIndex = array_search($chapterId, array_column($selectedCourse['chapters'], 'id'));

        $previousChapter = ($currentIndex > 0) ? $selectedCourse['chapters'][$currentIndex - 1] : null;
        $nextChapter = ($currentIndex < $chapterCount - 1) ? $selectedCourse['chapters'][$currentIndex + 1] : null;

        return $this->render('cours/show_course.html.twig', [
            'course' => $selectedCourse,
            'chapters' => $selectedCourse['chapters'],
            'chapter' => $currentChapter,
            'previousChapter' => $previousChapter,
            'nextChapter' => $nextChapter,
        ]);
    }
}
