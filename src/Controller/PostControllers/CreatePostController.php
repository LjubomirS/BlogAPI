<?php

namespace Module5Project\Controller\PostControllers;

use DateTimeImmutable;
use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module5Project\Controller\FileController;
use Module5Project\Entity\Post;
use Module5Project\Repository\PostRepository;
use Module5Project\Repository\PostsCategoriesRepository;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Cocur\Slugify\Slugify;
use PDO;
use Module5Project\Repository\CategoryRepository;

class CreatePostController
{
    private PostRepository $postRepository;
    private PostsCategoriesRepository $postsCategoriesRepository;
    private PDO $pdo;
    private CategoryRepository $categoryRepository;

    public function __construct(Container $container)
    {
        $this->postRepository = $container->get('post-repository');
        $this->postsCategoriesRepository = $container->get('posts_categories-repository');
        $this->pdo = $container->get('db');
        $this->categoryRepository = $container->get('category-repository');
    }

    public function __invoke(Request $request, Response $response, mixed $args): JsonResponse
    {
        try {
            $inputs = json_decode($request->getBody()->getContents(), true);

            if (
                empty($inputs['title']) || empty($inputs['content']) || empty($inputs['thumbnail']) ||
                empty($inputs['author']) || empty($inputs['categories'])
            ) {
                throw new \Exception('Missing required fields.');
            }

            if($this->postRepository->findByTitle($inputs)){
                throw new \Exception('Post with that title already exists.', 400);
            }

            $slugify = new Slugify();
            $slug = $slugify->slugify($inputs['title']);

            $postedAt = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

            $thumbnail = new FileController($inputs['thumbnail']);
            $filePath = 'http://localhost:8888/uploads/' . $thumbnail->handle();

            $categoryIds = $inputs['categories'];
            $categories = [];
            foreach ($categoryIds as $categoryId) {
                $category = $this->categoryRepository->read($categoryId);
                if ($category !== null) {
                    $categories[] = $category;
                }
            }

            $post = new Post(
                Uuid::uuid4(),
                $inputs['title'],
                $slug,
                $inputs['content'],
                $filePath,
                $inputs['author'],
                $postedAt,
                $categories
            );

            $this->postRepository->store($post);
            $this->postsCategoriesRepository->store($post);

            $displayPostData = $post->displayPost($post);

            return new JsonResponse($displayPostData);

        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}
