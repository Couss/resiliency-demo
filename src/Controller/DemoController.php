<?php

namespace App\Controller;

use Resiliency\Contracts\CircuitBreaker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    /**
     * @Route("/", name="demo")
     *
     * @param CircuitBreaker $simpleCircuitBreaker
     * @param CircuitBreaker $symfonyCircuitBreaker
     */
    public function index(
        CircuitBreaker $simpleCircuitBreaker,
        CircuitBreaker $symfonyCircuitBreaker
    ) {
        $responseFromSimpleCircuitBreaker = $simpleCircuitBreaker->call(
            'https://my-json-server.typicode.com/typicode/demo/comments',
            function () {
                return  json_encode([
                    ['id' => 1, 'body' => 'comment', 'postId' => 1]
                ]);
            },
            []
        );

        $responseFromSymfonyCircuitBreaker = $symfonyCircuitBreaker->call(
            'https://my-json-server.typicode.com/typicode/demo/posts',
            function () {
                return  json_encode([
                    ['id' => 1, 'title' => 'Post 1',]
                ]);
            },
            []
        );

        return $this->render('demo/index.html.twig', [
            'responseFromSimpleCircuitBreaker' => $responseFromSimpleCircuitBreaker,
            'responseFromSymfonyCircuitBreaker' => $responseFromSymfonyCircuitBreaker,
        ]);
    }
}
