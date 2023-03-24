<?php

namespace Module5Project\Controller\CategoryControllers;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module5Project\Repository\CategoryRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class UpdateCategoryController
{
    private CategoryRepository $categoryRepository;

    public function __construct(Container $container)
    {
        $this->categoryRepository = $container->get('category-repository');
    }

    public function __invoke(Request $request, Response $response, mixed $args): JsonResponse
    {
        try {
            $inputs = json_decode($request->getBody()->getContents(), true);

            $category = $this->categoryRepository->read($args);

            if (!$category) {
                throw new \Exception('Category not found.', 404);
            }

            if (empty($inputs['name']) || empty($inputs['description'])) {
                throw new \Exception('Missing required fields.', 400);
            }

            $this->categoryRepository->update($inputs, $args);

            $category = $this->categoryRepository->read($args);

            return new JsonResponse($category->toArray());
        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 400;
            return new JsonResponse(['error' => $e->getMessage()], $statusCode);
        }
    }
}
