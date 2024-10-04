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
            'chapters' => [], // entity chapters 
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
            'chapters' => [], // entity chapters
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
            'chapters' => [], // entity chapters
            'description' => 'The course covers Python syntax, working with data structures like lists and dictionaries, and using libraries to manipulate and visualize data.',
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
            'chapters' => [], // entity chapters
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
            'chapters' => [], // entity chapters
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
            'chapters' => [], // entity chapters
            'level' => 'Beginner',
            'estimated_time' => '2hrs',
            'created_at' => '2022-08-01',
            'updated_at' => '2022-08-03',
            'language' => 'SQL',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d1/SQLite370.svg/1200px-SQLite370.svg.png',
            'files' => [
                'https://www.w3schools.com/sql/',
                'https://www.sqltutorial.org/',
            ],
            'validated' => false,
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

    #[Route('/cours/{id}', name: 'app_courses_show', methods: ['GET'])]
    public function show($id): Response
    {
        $selectedCourse = null;
        foreach ($this->courses as $course) {
            if ($course['id'] == $id) {
                $selectedCourse = $course;
                break;
            }
        }

        $chapters = [
            [
                'id' => 1,
                'title' => 'Introduction',
                'description' => 'This chapter covers the basics of Java programming.',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin id viverra lacus. Pellentesque vitae elit pharetra, aliquet nibh non, varius sapien. Nullam ac purus a metus laoreet scelerisque. Fusce ullamcorper ornare ligula, vitae bibendum felis auctor nec. Donec vestibulum, lorem eu venenatis egestas, nulla libero maximus risus, eget sollicitudin felis arcu eu erat. Aliquam erat volutpat. Fusce ac lorem sed leo elementum placerat. Fusce feugiat, elit eget ornare fringilla, nisl mi sodales risus, sed volutpat nibh elit eget nunc. Sed sed metus dictum, rhoncus ipsum vulputate, tempus nisl. 
Donec pulvinar aliquam turpis ac varius. Donec posuere quis augue non interdum. Maecenas vehicula sapien nulla, placerat congue tortor consequat et. Proin tincidunt quam ac eleifend rutrum. Donec vel aliquet ligula, ac interdum purus. Nam sem tellus, accumsan nec vehicula at, feugiat vitae orci. Quisque porttitor nunc nisl, in ultricies velit condimentum ac.',
                'validated' => true,
            ],
            [
                'id' => 2,
                'title' => 'Advanced Topics',
                'description' => 'This chapter covers more advanced topics in Java programming.',
                'content' => 'lorem ipsum',
                'validated' => false,
            ],
            [
                'id' => 3,
                'title' => 'Practical Examples',
                'description' => 'This chapter provides practical examples of Java programming.',
                'content' => 'lorem ipsum',
                'validated' => false,
            ],
            [
                'id' => 4,
                'title' => 'Conclusion',
                'description' => 'This chapter concludes the Java programming course.',
                'content' => 'lorem ipsum',
                'validated' => false,
            ],
        ];

        $currentChapter = $chapters[0];

        if (!$selectedCourse) {
            throw $this->createNotFoundException('Course not found.');
        }

        return $this->render('cours/show.html.twig', [
            'course' => $selectedCourse,
            'chapters' => $chapters,
            'currentChapter' => $currentChapter
        ]);
    }
}
