<?php

namespace App\Controller;

use Resiliency\Contracts\CircuitBreaker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    const COMMENTS_SERVICE = 'https://my-json-server.typicode.com/typicode/demo/comments';
    const POSTS_SERVICE = 'https://my-json-server.typicode.com/typicode/demo/comments';

    /**
     * @Route("/", name="home")
     *
     * @param CircuitBreaker $simpleCircuitBreaker
     * @param CircuitBreaker $symfonyCircuitBreaker
     */
    public function index(
        CircuitBreaker $simpleCircuitBreaker,
        CircuitBreaker $symfonyCircuitBreaker
    ) {
        $responseFromSimpleCircuitBreaker = $simpleCircuitBreaker->call(
            self::COMMENTS_SERVICE,
            function () {
                return  json_encode([
                    ['id' => 1, 'body' => 'Response from fallback', 'postId' => 1]
                ]);
            },
            [
                'foo' => 'bar'
            ]
        );

        $responseFromSymfonyCircuitBreaker = $symfonyCircuitBreaker->call(
            self::POSTS_SERVICE,
            function () {
                return  json_encode([
                    ['id' => 1, 'title' => 'Response from callback',]
                ]);
            },
            [
                'foo' => 'bar'
            ]
        );

        return $this->render('demo/index.html.twig', [
            'responseFromSimpleCircuitBreaker' => $responseFromSimpleCircuitBreaker,
            'responseFromSymfonyCircuitBreaker' => $responseFromSymfonyCircuitBreaker,
        ]);
    }

    /**
     * @Route("/isolate", name="isolation")
     *
     * @param CircuitBreaker $simpleCircuitBreaker
     * @param CircuitBreaker $symfonyCircuitBreaker
     */
    public function isolate(
        CircuitBreaker $simpleCircuitBreaker,
        CircuitBreaker $symfonyCircuitBreaker
    ) {
        $simpleCircuitBreaker->isolate(self::COMMENTS_SERVICE);
        $symfonyCircuitBreaker->isolate(self::POSTS_SERVICE);

        $this->redirectToRoute('home');
    }

    /**
     * @Route("/reset", name="reset")
     *
     * @param CircuitBreaker $simpleCircuitBreaker
     * @param CircuitBreaker $symfonyCircuitBreaker
     */
    public function reset(
        CircuitBreaker $simpleCircuitBreaker,
        CircuitBreaker $symfonyCircuitBreaker
    ) {
        $simpleCircuitBreaker->reset(self::COMMENTS_SERVICE);
        $symfonyCircuitBreaker->reset(self::POSTS_SERVICE);

        $this->redirectToRoute('home');
    }
}
