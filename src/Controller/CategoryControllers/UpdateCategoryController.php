<?php

namespace Module4Project\Controller\CategoryControllers;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Module4Project\Repository\CategoryRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class UpdateCategoryController
{
    /**
     * @OA\Put(
     *     path="/v1/categories/update/{id}",
     *     description="Update contant and thumbnail of the post",
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
     *     @OA\RequestBody(
     *         description="Update category",
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
     *         description="Returns all the properties of the updated category"
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

            $data = $this->categoryRepository->read($args);

            return new JsonResponse($data);
        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 400;
            return new JsonResponse(['error' => $e->getMessage()], $statusCode);
        }
    }
}
