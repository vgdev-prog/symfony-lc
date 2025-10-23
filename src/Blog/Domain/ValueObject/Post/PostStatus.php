<?php

declare(strict_types=1);

namespace App\Blog\Domain\ValueObject\Post;

enum PostStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';
}
