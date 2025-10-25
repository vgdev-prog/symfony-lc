<?php

declare(strict_types=1);

namespace App\Blog\Domain\Exception;

enum ErrorCode:string
{
   case BLOG_POST_MISSING_REQUIRED_FIELDS = 'BLOG_POST_MISSING_REQUIRED_FIELDS';
}
