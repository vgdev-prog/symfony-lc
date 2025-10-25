<?php

declare(strict_types=1);

namespace App\Blog\Application\DTO;

use App\Common\Domain\Enum\Locale;

/**
 * Request DTO for retrieving a post.
 *
 * Encapsulates the input data required to fetch a post
 * with translations in a specific locale.
 */
final readonly class GetPostRequest
{
    public function __construct(
        public string $postId,
        public Locale $locale
    ) {
    }
}