<?php

namespace Module4Project\Controller\CategoryControllers;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module4Project\Repository\CategoryRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class GetAllCategoriesController
{
    /**
     * @OA\Get(
     *     path="/v1/categories",
     *     description="All the categories in the app",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response="200",
     *         description="Returns the list of all the categories"
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
        $allCategories = $this->categoryRepository->getAllCategories();

        return new JsonResponse($allCategories);
    }
}
