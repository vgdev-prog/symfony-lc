<?php

declare(strict_types=1);

namespace App\Common\Domain\Trait;

use App\Common\Domain\Enum\Locale;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Provides translation support for domain entities via Gedmo Translatable extension.
 *
 * Entities using this trait can have translatable fields by adding #[Gedmo\Translatable]
 * attribute to properties that should support multiple language versions.
 *
 * Example usage:
 * <code>
 * class Post extends Model
 * {
 *     use Translatable;
 *
 *     #[Gedmo\Translatable]
 *     private string $title;
 *
 *     public function changeTitle(string $title, Locale $locale): void
 *     {
 *         $this->setTranslatableLocale($locale);
 *         $this->title = $title;
 *     }
 * }
 * </code>
 */
trait Translatable
{
    /**
     * Current locale for translatable fields (transient, not persisted to database).
     *
     * This property is used by Gedmo Translatable extension to determine which
     * language version to load/save for fields marked with #[Gedmo\Translatable].
     *
     * IMPORTANT: This is a transient field - it is NOT stored in the database.
     * It only exists in memory during runtime to control translation behavior.
     *
     * @var string|null Locale code (e.g., 'en', 'ru', 'ua', 'pl')
     */
    #[Gedmo\Locale]
    protected ?string $locale = null;

    /**
     * Sets the current locale for translatable fields.
     *
     * This method switches the language context for the entity. After calling this,
     * any reads or writes to translatable fields will use the specified locale.
     *
     * When creating translations:
     * - Set the locale before modifying translatable fields
     * - Flush changes to persist the translation
     * - Change locale and repeat for additional languages
     *
     * When reading translations:
     * - Set the locale before accessing translatable fields
     * - Call EntityManager::refresh() to reload from database
     *
     * @param Locale $locale The locale to use for subsequent operations
     * @return void
     */
    public function setTranslatableLocale(Locale $locale): void
    {
        $this->locale = $locale->value;
    }

    /**
     * Returns the current locale set for this entity.
     *
     * @return string|null Current locale code or null if not set
     */
    public function getLocale(): ?string
    {
        return $this->locale;
    }
}
