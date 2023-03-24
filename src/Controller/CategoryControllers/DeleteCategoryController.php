<?php

namespace Module5Project\Controller\CategoryControllers;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module5Project\Repository\CategoryRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class DeleteCategoryController
{
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

        $this->categoryRepository->delete($args);


        $output = [
            "status" => "Category deleted"
        ];

        return new JsonResponse($output);
    }
}
