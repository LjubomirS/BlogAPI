<?php

namespace Module4Project\Controller\PostControllers;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module4Project\Repository\PostRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use OpenApi\Annotations as OA;

class GetAllPostsController
{
    /**
     * @OA\Get(
     *     path="/v1/posts",
     *     description="All the posts in the app",
     *     tags={"Posts"},
     *     @OA\Response(
     *         response="200",
     *         description="Returns the list of all the posts"
     *     )
     * )
     */

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
