<?php

declare(strict_types=1);

namespace App\Common\Domain\Exception;

abstract class AbstractDomainException extends \DomainException
{
    final public static function getStatusCode(): int
    {
        return 400;
    }

    /**
     * Provides unique error code for client-side error handling and
    logging.
     *
     * Error codes should follow the pattern: MODULE_ENTITY_ERROR_REASON
     *
     * Examples:
     * - BLOG_POST_ALREADY_PUBLISHED
     * - BLOG_INVALID_UUID_FORMAT
     * - USER_UNAUTHORIZED_ACTION
     * - CATEGORY_NOT_FOUND
     *
     * @return string Unique error code in UPPER_SNAKE_CASE format
     */
    abstract public static function getDomainErrorCode(): string;

    /**
     * Returns additional context data to be included in API error response.
     *
     * @return array<string, mixed>
     */

    public function getPublicContext(): array
    {
        return [];
    }

    /**
     * Provides example context structure for API documentation and schema
     * generation.
     * @return array
     */
    public static function getExamplePublicContext(): array
    {
        return [];
    }
}
