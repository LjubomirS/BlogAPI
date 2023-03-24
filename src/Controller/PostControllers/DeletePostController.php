<?php

namespace Module5Project\Controller\PostControllers;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module5Project\Repository\PostRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class DeletePostController
{
    private PostRepository $postRepository;

    public function __construct(Container $container)
    {
        $this->postRepository = $container->get('post-repository');
    }

    public function __invoke(Request $request, Response $response, mixed $args): JsonResponse
    {
        $post = $this->postRepository->read($args);

        if (!$post) {
            return new JsonResponse(['error' => 'Post not found.'], 404);
        }

        $this->postRepository->delete($args);

        $output = [
            "status" => "Post deleted"
        ];

        return new JsonResponse($output);
    }
}
