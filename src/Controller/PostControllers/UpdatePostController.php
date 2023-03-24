<?php

namespace Module5Project\Controller\PostControllers;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module5Project\Controller\FileController;
use Module5Project\Repository\PostRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class UpdatePostController
{
    private PostRepository $postRepository;

    public function __construct(Container $container)
    {
        $this->postRepository = $container->get('post-repository');
    }

    public function __invoke(Request $request, Response $response, mixed $args): JsonResponse
    {
        try {
            $inputs = json_decode($request->getBody()->getContents(), true);

            $post = $this->postRepository->read($args);

            if (!$post) {
                throw new \Exception('Post not found.', 404);
            }

            if (empty($inputs['content']) || empty($inputs['thumbnail'])) {
                throw new \Exception('Missing required fields.', 400);
            }

            $thumbnail = new FileController($inputs['thumbnail']);
            $filePath = 'http://localhost:8888/uploads/' . $thumbnail->handle();

            $propertiesToUpdate = [
                'content' => $inputs['content'],
                'thumbnail' => $filePath
            ];

            $this->postRepository->update($propertiesToUpdate, $args);

            $post = $this->postRepository->read($args);

            return new JsonResponse($post->toArray());
        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 400;
            return new JsonResponse(['error' => $e->getMessage()], $statusCode);
        }
    }
}
