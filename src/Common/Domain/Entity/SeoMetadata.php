<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Common\Domain\Dto\SeoMetadataDTO;
use App\Common\Domain\Enum\Locale;
use App\Common\Domain\Trait\Translatable;
use App\Common\Domain\ValueObject\EntityTypeMap;
use App\Common\Domain\ValueObject\SeoMetadataId;
use App\Common\Domain\ValueObject\Undefined;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SEO Metadata Entity
 *
 * Stores SEO metadata for different entities in the system.
 * Supports multilingual content via Gedmo Translatable for text fields.
 */
#[ORM\Entity]
#[ORM\Table(name: 'seo_metadata')]
class SeoMetadata
{
    use Translatable;

    /**
     * Unique identifier for SEO metadata
     */
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private SeoMetadataId $id;

    /**
     * Full class name of the related entity (FQCN)
     * Example: App\Blog\Domain\Entity\Post
     */
    #[ORM\Column(type: 'string', length: 255)]
    private string $entityClass;

    /**
     * ID of the related entity
     */
    #[ORM\Column(type: 'string', length: 255)]
    private string $entityId;

    /**
     * Meta Title - page title in search results
     * Recommended length: 50-60 characters
     */
    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $title = null;

    /**
     * Meta Description - page description in search results
     * Recommended length: 150-160 characters
     */
    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * Meta Keywords - keywords for the page (deprecated but sometimes used)
     */
    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $keywords = null;

    /**
     * Open Graph Title - title when shared on Facebook, LinkedIn
     * If not set, falls back to title
     */
    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ogTitle = null;

    /**
     * Open Graph Description - description when shared on social media
     * If not set, falls back to description
     */
    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ogDescription = null;

    /**
     * Open Graph Image - image URL for social media preview
     * Recommended size: 1200x630 pixels
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ogImage = null;

    /**
     * Open Graph Type - content type
     * Possible values: website, article, product, etc.
     */
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ogType = null;

    /**
     * Twitter Card Title - title for Twitter card
     * If not set, falls back to ogTitle or title
     */
    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $twitterTitle = null;

    /**
     * Twitter Card Description - description for Twitter card
     */
    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $twitterDescription = null;

    /**
     * Twitter Card Image - image for Twitter card
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $twitterImage = null;

    /**
     * Twitter Card Type - type of Twitter card
     * Possible values: summary, summary_large_image, app, player
     */
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $twitterCard = null;

    /**
     * Canonical URL - canonical address of the page
     * Used to prevent duplicate content
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $canonicalUrl = null;

    /**
     * No Index - prevent search engines from indexing this page
     * true = page will not be indexed
     */
    #[ORM\Column(nullable: true)]
    private ?bool $noIndex = false;

    /**
     * No Follow - prevent search engines from following links on this page
     * true = search engines will not follow links
     */
    #[ORM\Column(nullable: true)]
    private ?bool $noFollow = false;

    /**
     * Get SEO metadata ID
     *
     * @return SeoMetadataId
     */
    public function id(): SeoMetadataId
    {
        return $this->id;
    }

    /**
     * Get entity class (mapped type)
     *
     * @return string
     */
    public function entityClass(): string
    {
        return $this->entityClass;
    }

    /**
     * Get entity ID
     *
     * @return string
     */
    public function entityId(): string
    {
        return $this->entityId;
    }

    /**
     * Get meta title
     *
     * @param Locale $locale
     * @return string|null
     */
    public function title(Locale $locale): ?string
    {
        $this->setTranslatableLocale($locale);
        return $this->title;
    }

    /**
     * Get meta description
     *
     * @param Locale $locale
     * @return string|null
     */
    public function description(Locale $locale): ?string
    {
        $this->setTranslatableLocale($locale);
        return $this->description;
    }

    /**
     * Get meta keywords
     *
     * @param Locale $locale
     * @return string|null
     */
    public function keywords(Locale $locale): ?string
    {
        $this->setTranslatableLocale($locale);
        return $this->keywords;
    }

    /**
     * Get Open Graph title
     *
     * @param Locale $locale
     * @return string|null
     */
    public function ogTitle(Locale $locale): ?string
    {
        $this->setTranslatableLocale($locale);
        return $this->ogTitle;
    }

    /**
     * Get Open Graph description
     *
     * @param Locale $locale
     * @return string|null
     */
    public function ogDescription(Locale $locale): ?string
    {
        $this->setTranslatableLocale($locale);
        return $this->ogDescription;
    }

    /**
     * Get Open Graph image URL
     *
     * @return string|null
     */
    public function ogImage(): ?string
    {
        return $this->ogImage;
    }

    /**
     * Get Open Graph type
     *
     * @return string|null
     */
    public function ogType(): ?string
    {
        return $this->ogType;
    }

    /**
     * Get Twitter card title
     *
     * @param Locale $locale
     * @return string|null
     */
    public function twitterTitle(Locale $locale): ?string
    {
        $this->setTranslatableLocale($locale);
        return $this->twitterTitle;
    }

    /**
     * Get Twitter card description
     *
     * @param Locale $locale
     * @return string|null
     */
    public function twitterDescription(Locale $locale): ?string
    {
        $this->setTranslatableLocale($locale);
        return $this->twitterDescription;
    }

    /**
     * Get Twitter card image URL
     *
     * @return string|null
     */
    public function twitterImage(): ?string
    {
        return $this->twitterImage;
    }

    /**
     * Get Twitter card type
     *
     * @return string|null
     */
    public function twitterCard(): ?string
    {
        return $this->twitterCard;
    }

    /**
     * Get canonical URL
     *
     * @return string|null
     */
    public function canonicalUrl(): ?string
    {
        return $this->canonicalUrl;
    }

    /**
     * Get no-index flag
     *
     * @return bool|null
     */
    public function noIndex(): ?bool
    {
        return $this->noIndex;
    }

    /**
     * Get no-follow flag
     *
     * @return bool|null
     */
    public function noFollow(): ?bool
    {
        return $this->noFollow;
    }

    /**
     * Create new SEO metadata instance
     *
     * @param string $class Entity class name
     * @param string $id Entity ID
     * @param SeoMetadataDTO $metadata SEO data
     * @param Locale $locale Locale for translatable fields
     * @return self
     */
    public function updateOrGenerate(string $class, string $id, SeoMetadataDTO $metadata, Locale $locale, ?SeoMetadata $entity): static
    {
        $seo = $entity ?: new self();
        $seo->id = $seo->id() ?: SeoMetadataId::generate();
        $seo->attachClass($class, $id);
        $seo->fill(context: $metadata, locale: $locale);
        return $seo;
    }

    /**
     * Fill SEO metadata from DTO
     * Only updates fields that are not Undefined
     *
     * @param SeoMetadataDTO $context SEO data to fill
     * @param Locale $locale Locale for translatable fields
     * @return void
     */
    public function fill(SeoMetadataDTO $context, Locale $locale): void
    {
        if (!Undefined::equalsTo($context->title)) {
            $this->withTitle($context->title, $locale);
        }
        if (!Undefined::equalsTo($context->description)) {
            $this->withDescription($context->description, $locale);
        }
        if (!Undefined::equalsTo($context->keywords)) {
            $this->withKeywords($context->keywords, $locale);
        }
        if (!Undefined::equalsTo($context->ogTitle)) {
            $this->withOgTitle($context->ogTitle, $locale);
        }
        if (!Undefined::equalsTo($context->ogDescription)) {
            $this->withOgDescription($context->ogDescription, $locale);
        }
        if (!Undefined::equalsTo($context->ogImage)) {
            $this->withOgImage($context->ogImage);
        }
        if (!Undefined::equalsTo($context->ogType)) {
            $this->withOgType($context->ogType);
        }
        if (!Undefined::equalsTo($context->twitterTitle)) {
            $this->withTwitterTitle($context->twitterTitle, $locale);
        }
        if (!Undefined::equalsTo($context->twitterDescription)) {
            $this->withTwitterDescription($context->twitterDescription, $locale);
        }
        if (!Undefined::equalsTo($context->twitterImage)) {
            $this->withTwitterImage($context->twitterImage);
        }
        if (!Undefined::equalsTo($context->twitterCard)) {
            $this->withTwitterCard($context->twitterCard);
        }
        if (!Undefined::equalsTo($context->canonicalUrl)) {
            $this->withCanonicalUrl($context->canonicalUrl);
        }
        if (!Undefined::equalsTo($context->noIndex)) {
            $this->withNoIndex($context->noIndex);
        }
        if (!Undefined::equalsTo($context->noFollow)) {
            $this->withNoFollow($context->noFollow);
        }

    }

    /**
     * Set meta title
     *
     * @param string|null $title
     * @param Locale $locale
     * @return void
     */
    public function withTitle(?string $title, Locale $locale): void
    {
        $this->setTranslatableLocale($locale);
        $this->title = $title;
    }

    /**
     * Set meta description
     *
     * @param string|null $description
     * @param Locale $locale
     * @return void
     */
    public function withDescription(?string $description, Locale $locale): void
    {
        $this->setTranslatableLocale($locale);
        $this->description = $description;
    }

    /**
     * Set meta keywords
     *
     * @param string|null $keywords
     * @param Locale $locale
     * @return void
     */
    public function withKeywords(?string $keywords, Locale $locale): void
    {
        $this->setTranslatableLocale($locale);
        $this->keywords = $keywords;
    }

    /**
     * Set Open Graph title
     *
     * @param string|null $ogTitle
     * @param Locale $locale
     * @return void
     */
    public function withOgTitle(?string $ogTitle, Locale $locale): void
    {
        $this->setTranslatableLocale($locale);
        $this->ogTitle = $ogTitle;
    }

    /**
     * Set Open Graph description
     *
     * @param string|null $ogDescription
     * @param Locale $locale
     * @return void
     */
    public function withOgDescription(?string $ogDescription, Locale $locale): void
    {
        $this->setTranslatableLocale($locale);
        $this->ogDescription = $ogDescription;
    }

    /**
     * Set Open Graph image URL
     *
     * @param string|null $ogImage
     * @return void
     */
    public function withOgImage(?string $ogImage): void
    {
        $this->ogImage = $ogImage;
    }

    /**
     * Set Open Graph type
     *
     * @param string|null $ogType
     * @return void
     */
    public function withOgType(?string $ogType): void
    {
        $this->ogType = $ogType;
    }

    /**
     * Set Twitter card title
     *
     * @param string|null $twitterTitle
     * @param Locale $locale
     * @return void
     */
    public function withTwitterTitle(?string $twitterTitle, Locale $locale): void
    {
        $this->setTranslatableLocale($locale);
        $this->twitterTitle = $twitterTitle;
    }

    /**
     * Set Twitter card description
     *
     * @param string|null $twitterDescription
     * @param Locale $locale
     * @return void
     */
    public function withTwitterDescription(?string $twitterDescription, Locale $locale): void
    {
        $this->setTranslatableLocale($locale);
        $this->twitterDescription = $twitterDescription;
    }

    /**
     * Set Twitter card image URL
     *
     * @param string|null $twitterImage
     * @return void
     */
    public function withTwitterImage(?string $twitterImage): void
    {
        $this->twitterImage = $twitterImage;
    }

    /**
     * Set Twitter card type
     *
     * @param string|null $twitterCard
     * @return void
     */
    public function withTwitterCard(?string $twitterCard): void
    {
        $this->twitterCard = $twitterCard;
    }

    /**
     * Set canonical URL
     *
     * @param string|null $canonicalUrl
     * @return void
     */
    public function withCanonicalUrl(?string $canonicalUrl): void
    {
        $this->canonicalUrl = $canonicalUrl;
    }

    /**
     * Set no-index flag
     *
     * @param bool|null $noIndex
     * @return void
     */
    public function withNoIndex(?bool $noIndex): void
    {
        $this->noIndex = $noIndex;
    }

    /**
     * Set no-follow flag
     *
     * @param bool|null $noFollow
     * @return void
     */
    public function withNoFollow(?bool $noFollow): void
    {
        $this->noFollow = $noFollow;
    }

    /**
     * Attach SEO metadata to entity
     *
     * @param string $entityClass Entity class name
     * @param string $id Entity ID
     * @return void
     */
    public function attachClass(string $entityClass, string $id): void
    {
        $this->entityClass = EntityTypeMap::getType($entityClass);
        $this->entityId = $id;
    }


}
