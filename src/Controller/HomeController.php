<?php

namespace Module4Project\Controller;

use Laminas\Diactoros\Response\JsonResponse;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class HomeController
{
    public function __invoke(Request $request, Response $response, mixed $args): JsonResponse
    {
        $data = ['app' => 'module_4_project', 'version' => '1.0'];

        return new JsonResponse($data);
    }
}
