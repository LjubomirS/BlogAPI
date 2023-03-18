<?php

namespace Module4Project\Controller\CategoryControllers;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module4Project\Entity\Category;
use Module4Project\Repository\CategoryRepository;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class CreateCategoryController
{
    /**
     * @OA\Post(
     *     path="/v1/categories/create",
     *     description="Creates a new category",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *         description="Category to add.",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="aplication/json",
     *             @OA\Schema(
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="description", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns all the properties of a created category"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request"
     *     )
     * )
     */

    private CategoryRepository $categoryRepository;

    public function __construct(Container $container)
    {
        $this->categoryRepository = $container->get('category-repository');
    }

    public function __invoke(Request $request, Response $response, mixed $args): JsonResponse
    {
        try {
            $inputs = json_decode($request->getBody()->getContents(), true);

            $categories = $this->categoryRepository->getAllCategories();

            foreach ($categories as $category) {
                if ($category['name'] === $inputs['name']) {
                    throw new \Exception('Category with that name already exists.', 400);
                }
            }

            if (empty($inputs['name']) || empty($inputs['description'])) {
                throw new \Exception('Missing required fields.');
            }

            $category = new Category(
                Uuid::uuid4(),
                $inputs['name'],
                $inputs['description']
            );

            $this->categoryRepository->store($category);

            $output = [
                'id' => $category->categoryId(),
                'name' => $category->name(),
                'description' => $category->description()
            ];

            return new JsonResponse($output);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}
