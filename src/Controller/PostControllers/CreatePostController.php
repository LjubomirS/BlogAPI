<?php

namespace Module4Project\Controller\PostControllers;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module4Project\Controller\FileController;
use Module4Project\Entity\Post;
use Module4Project\Repository\PostRepository;
use Module4Project\Repository\PostsCategoriesRepository;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Cocur\Slugify\Slugify;
use PDO;
use OpenApi\Annotations as OA;

class CreatePostController
{
    /**
     * @OA\Post(
     *     path="/v1/posts/create",
     *     description="Creates new post",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         description="Post to add.",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="aplication/json",
     *             @OA\Schema(
     *                  @OA\Property(property="title", type="string"),
     *                  @OA\Property(property="content", type="string"),
     *                  @OA\Property(property="thumbnail", type="string"),
     *                  @OA\Property(property="author", type="string"),
     *                  @OA\Property(
     *                     property="categories",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="string", format="uuid")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns all the properties of the created post"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request"
     *     )
     * )
     */

    private PostRepository $postRepository;
    private PostsCategoriesRepository $postsCategoriesRepository;
    private PDO $pdo;

    public function __construct(Container $container)
    {
        $this->postRepository = $container->get('post-repository');
        $this->postsCategoriesRepository = $container->get('posts_categories-repository');
        $this->pdo = $container->get('db');
    }

    public function __invoke(Request $request, Response $response, mixed $args): JsonResponse
    {
        try {
            $this->pdo->beginTransaction();

            $inputs = json_decode($request->getBody()->getContents(), true);

            $posts = $this->postRepository->getAllPosts();

            foreach ($posts as $post) {
                if ($post['title'] === $inputs['title']) {
                    throw new \Exception('Post with that title already exists.', 400);
                }
            }

            if (
                empty($inputs['title']) || empty($inputs['content']) || empty($inputs['thumbnail']) ||
                empty($inputs['author']) || empty($inputs['categories'])
            ) {
                throw new \Exception('Missing required fields.');
            }

            $slugify = new Slugify();
            $slug = $slugify->slugify($inputs['title']);

            $postedAt = date('Y-m-d H:i:s');

            $thumbnail = new FileController($inputs['thumbnail']);
            $filePath = 'http://localhost:8888/uploads/' . $thumbnail->handle();

            $post = new Post(
                Uuid::uuid4(),
                $inputs['title'],
                $slug,
                $inputs['content'],
                $filePath,
                $inputs['author'],
                $postedAt,
                $inputs['categories']
            );

            $this->postRepository->store($post);
            $this->postsCategoriesRepository->store($post);

            $this->pdo->commit();

            $output = [
                'id' => $post->postId(),
                'title' => $post->title(),
                'slug' => $post->slug(),
                'content' => $post->content(),
                'thumbnail' => $post->thumbnail(),
                'author' => $post->author(),
                'posted_at' => $post->postedAt(),
                'categories' => $post->categories()
            ];

            return new JsonResponse($output);
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}
