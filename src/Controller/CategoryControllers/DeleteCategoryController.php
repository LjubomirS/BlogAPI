<?php

namespace Module4Project\Controller\CategoryControllers;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module4Project\Repository\CategoryRepository;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class DeleteCategoryController
{
    /**
     * @OA\Delete(
     *     path="/v1/categories/delete/{id}",
     *     description="Deletes the category based on the {id} paramether added to the route path.",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         description="ID of the category to delete",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns confirmation that the category is deleted"
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

        $this->categoryRepository->delete($args);


        $output = [
            "status" => "Category deleted"
        ];

        return new JsonResponse($output);
    }
}
