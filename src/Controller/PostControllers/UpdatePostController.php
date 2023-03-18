<?php

namespace Module4Project\Controller\PostControllers;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module4Project\Repository\PostRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class UpdatePostController
{
    /**
     * @OA\Put(
     *     path="/v1/posts/update/{slug}",
     *     description="Update contant and thumbnail of the post",
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
     *     @OA\RequestBody(
     *         description="Update post",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="aplication/json",
     *             @OA\Schema(
     *                  @OA\Property(property="content", type="string"),
     *                  @OA\Property(property="thumbnail", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns all the properties of the updated post"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Category not found"
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
        try {
            $inputs = json_decode($request->getBody()->getContents(), true);

            $post = $this->postRepository->read($args);

            if (!$post) {
                throw new \Exception('Post not found.', 404);
            }

            if (empty($inputs['content']) || empty($inputs['thumbnail'])) {
                throw new \Exception('Missing required fields.', 400);
            }

            $this->postRepository->update($inputs, $args);

            $data = $this->postRepository->read($args);

            return new JsonResponse($data);
        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 400;
            return new JsonResponse(['error' => $e->getMessage()], $statusCode);
        }
    }
}
