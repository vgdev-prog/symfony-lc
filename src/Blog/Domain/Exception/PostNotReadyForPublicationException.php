<?php

declare(strict_types=1);

namespace App\Blog\Domain\Exception;

use App\Blog\Domain\ValueObject\Post\PostStatus;
use App\Common\Domain\Exception\AbstractDomainException;

class PostNotReadyForPublicationException extends AbstractDomainException
{
    private function __construct(
        string                   $message,
        private readonly string  $field,
        private readonly ?string $additionalInfo = null,
    )
    {
        parent::__construct($message);
    }

    public static function missingTitle():static
    {
       return new static(
            message: 'Cannot publish post without title',
            field: 'title'
        );
    }

    public static function missingDescription():static
    {
       return new static(
            message: 'Cannot publish post without description',
            field: 'description'
        );
    }

    public static function missingContent(): static
    {
       return new static(
            message: 'Cannot publish post without content',
            field: 'content'
        );

    }

    public static function alreadyPublished(): static
    {
       return new static(
            message: 'Already published',
            field: 'status',
            additionalInfo: "Published post can not be" . PostStatus::PUBLISHED->value
        );
    }

    public static function getDomainErrorCode(): string
    {
        return ErrorCode::BLOG_POST_MISSING_REQUIRED_FIELDS->value;
    }

    public function getPublicContext(): array
    {
        return [
            'field' => $this->field,
            'additionalInfo' => $this->additionalInfo,
        ];
    }

    public static function getExamplePublicContext(): array
    {
        return [
            'field' => 'title',
        ];
    }
}
