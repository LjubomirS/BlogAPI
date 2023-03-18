<?php

namespace Module4Project\Controller\CategoryControllers;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module4Project\Repository\CategoryRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ReadCategoryController
{
    /**
     * @OA\Get(
     *     path="/v1/categories/{id}",
     *     description="Returns a category based on the {id} paramether added to the route path.",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         description="ID of the category to fetch",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns all the properties of the category"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Category not found"
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
        $category = $this->categoryRepository->read($args);

        if (!$category) {
            return new JsonResponse(['error' => 'Category not found.'], 404);
        }

        return new JsonResponse($category);
    }
}
