<?php

declare(strict_types=1);

namespace App\Blog\Application\DTO;

use App\Blog\Domain\ValueObject\Post\PostStatus;
use DateTimeImmutable;

/**
 * Response DTO representing a post with its translated content.
 *
 * Contains all post data in the requested locale, ready for presentation layer.
 * This DTO decouples the domain model from the presentation layer.
 */
final readonly class PostResponse
{
    public function __construct(
        public string $id,
        public string $title,
        public ?string $description,
        public string $content,
        public PostStatus $status,
        public ?DateTimeImmutable $publishedAt,
        public string $locale
    ) {
    }
}