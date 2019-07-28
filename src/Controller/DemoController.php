<?php

namespace App\Controller;

use Resiliency\Contracts\CircuitBreaker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    const COMMENTS_SERVICE = 'https://my-json-server.typicode.com/typicode/demo/comments';

    /**
     * @Route("/", name="home")
     *
     * @param CircuitBreaker $circuitBreaker
     */
    public function index(CircuitBreaker $circuitBreaker) {
        $responseFromCircuitBreaker = $circuitBreaker->call(
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

        return $this->render('demo/index.html.twig', [
            'responseFromCircuitBreaker' => $responseFromCircuitBreaker,
        ]);
    }

    /**
     * @Route("/isolate", name="isolation")
     *
     * @param CircuitBreaker $circuitBreaker
     */
    public function isolate(CircuitBreaker $circuitBreaker)
    {
        $circuitBreaker->isolate(self::COMMENTS_SERVICE);

        $this->redirectToRoute('home');
    }

    /**
     * @Route("/reset", name="reset")
     *
     * @param CircuitBreaker $circuitBreaker
     */
    public function reset(CircuitBreaker $circuitBreaker)
    {
        $circuitBreaker->reset(self::COMMENTS_SERVICE);
        $this->redirectToRoute('home');
    }
}
