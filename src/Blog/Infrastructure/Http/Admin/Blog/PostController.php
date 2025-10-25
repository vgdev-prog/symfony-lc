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
        $date = "10-10-2025";
       dump($date);
       $toArray = explode("-", $date);
       dump($toArray);
       $implodeToDots = implode(".", $toArray);
       dd($implodeToDots);

           dd(11);
        return new JsonResponse([
            'code' => Response::HTTP_OK,
        ]);
    }
}
