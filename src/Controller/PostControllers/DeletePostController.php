<?php

namespace Module4Project\Controller\PostControllers;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module4Project\Repository\PostRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class DeletePostController
{
    /**
     * @OA\Delete(
     *     path="/v1/posts/delete/{slug}",
     *     description="Deletes a post based on the {slug} paramether added to the route path.",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         description="Slug of the post to delete",
     *         in="path",
     *         name="slug",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns confirmation that post is deleted"
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

        $this->postRepository->delete($args);

        $output = [
            "status" => "Post deleted"
        ];

        return new JsonResponse($output);
    }
}
