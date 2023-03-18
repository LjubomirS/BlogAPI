<?php

namespace Module4Project\Controller\PostControllers;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module4Project\Repository\PostRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use OpenApi\Annotations as OA;

class ReadPostController
{
    /**
     * @OA\Get(
     *     path="/v1/posts/{slug}",
     *     description="Returns a post based on the {slug} paramether added to the route path.",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         description="Slug of the post to fetch",
     *         in="path",
     *         name="slug",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns all the properties of the post"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Post not found"
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
        $post = $this->postRepository->read($args);

        if (!$post) {
            return new JsonResponse(['error' => 'Post not found.'], 404);
        }

        return new JsonResponse($post);
    }
}
