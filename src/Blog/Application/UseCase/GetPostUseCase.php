<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase;

use App\Blog\Application\DTO\GetPostRequest;
use App\Blog\Application\DTO\PostResponse;
use App\Blog\Domain\Repository\PostRepositoryInterface;
use App\Blog\Domain\ValueObject\Post\PostId;

/**
 * Use Case for retrieving a post with translations.
 *
 * This demonstrates the proper DDD approach:
 * 1. DTO comes into the use case from the presentation layer
 * 2. Repository loads the entity with the correct locale using Gedmo hints
 * 3. Entity is already hydrated with translations in the requested locale
 * 4. Use case maps the entity to a response DTO
 * 5. Response DTO goes back to the presentation layer
 *
 * Key point: The entity itself doesn't need to know about locale switching.
 * The repository handles loading with the correct locale, and the entity
 * properties contain the translated values.
 */
final readonly class GetPostUseCase
{
    public function __construct(
        private PostRepositoryInterface $postRepository
    ) {
    }

    /**
     * Executes the use case to retrieve a post.
     *
     * @param GetPostRequest $request Request containing post ID and locale
     * @return PostResponse Response DTO with post data in requested locale
     * @throws \RuntimeException If post not found
     */
    public function execute(GetPostRequest $request): PostResponse
    {
        $postId = PostId::fromString($request->postId);

        $post = $this->postRepository->findById($postId, $request->locale);

        if ($post === null) {
            throw new \RuntimeException("Post with ID {$request->postId} not found");
        }

        // 3. At this point, $post->title, $post->content, etc. are already
        //    in the requested locale thanks to the repository hint
        //    We can access them directly without any locale parameter

        // 4. Map domain entity to response DTO
        return new PostResponse(
            id: $post->id()->value(),
            title: $post->title(),           // Already in correct locale!
            description: $post->description(), // Already in correct locale!
            content: $post->content(),        // Already in correct locale!
            status: $post->status(),
            publishedAt: $post->publishedAt(),
            locale: $request->locale->value
        );
    }
}
