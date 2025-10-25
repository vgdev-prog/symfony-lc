<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Http\Admin\Blog;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/blog', name: 'admin.blog.posts.')]
class PostController
{
    #[Route('/posts', name: 'listAll', methods: ['GET'])]
    public function index(): Response
    {
        return new JsonResponse([
            'code' => Response::HTTP_OK,
        ]);
    }
}
