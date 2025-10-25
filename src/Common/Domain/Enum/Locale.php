<?php

declare(strict_types=1);

namespace App\Common\Domain\Enum;

/**
 * Supported application locales.
 *
 * This enum defines all available language options for the application.
 * Used for content translation, UI localization, and user preferences.
 */
enum Locale: string
{
    case ENGLISH = 'en';

    case RUSSIAN = 'ru';

    case UKRAINIAN = 'ua';

    case POLAND = 'pl';

    /**
     * Returns all available locale codes.
     *
     * Useful for validation, dropdowns, and checking if a locale is supported.
     *
     * @return array<int, string> Array of locale codes ['en', 'ru', 'ua', 'pl']
     */
    public static function languages(): array
    {
        return array_column(self::cases(), 'value');
    }
}
