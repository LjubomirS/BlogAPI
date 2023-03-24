<?php

namespace Module5Project\Controller\PostControllers;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module5Project\Repository\PostRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class GetAllPostsController
{
    private PostRepository $postRepository;

    public function __construct(Container $container)
    {
        $this->postRepository = $container->get('post-repository');
    }

    public function __invoke(Request $request, Response $response, mixed $args): JsonResponse
    {
        $allPosts = $this->postRepository->getAllPosts();

        return new JsonResponse($allPosts);
    }
}
