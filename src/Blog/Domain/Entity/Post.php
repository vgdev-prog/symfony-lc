<?php

declare(strict_types=1);

namespace App\Blog\Domain\Entity;

use App\Blog\Domain\Exception\PostNotReadyForPublicationException;
use App\Blog\Domain\ValueObject\Post\PostId;
use App\Blog\Domain\ValueObject\Post\PostStatus;
use App\Common\Domain\Attribute\EntityType;
use App\Common\Domain\Entity\Model;
use App\Common\Domain\Entity\SeoMetadata;
use App\Common\Domain\Enum\Locale;
use App\Common\Domain\Trait\Translatable;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[EntityType('blog_post')]
#[ORM\Entity()]
class Post extends Model
{
    use Translatable;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private string $id;

    #[Gedmo\Translatable]
    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private string $content;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $publishedAt = null;

    #[ORM\Column(length: 255)]
    private PostStatus $status;

    #[ORM\OneToOne]
    private SeoMetadata $seoMetadata;

    /**
     * Post constructor.
     *
     * @param PostId $id Post identifier
     * @param PostStatus $status Initial post status
     */
    public function __construct(PostId $id, PostStatus $status)
    {
        $this->id = $id->value();
        $this->status = $status;
    }

    /**
     * Creates a new post instance with generated ID and DRAFT status.
     *
     * @return self New post instance
     */
    public static function create(): self
    {
        return new self(
            id: PostId::generate(),
            status: PostStatus::DRAFT
        );
    }

    /**
     * Queries
     *
     * Note: All translatable fields (title, description, content) return values
     * in the locale that was used when loading the entity from the repository.
     * Use PostRepository::findById($id, $locale) to load with specific locale.
     */

    /**
     * Returns the post identifier.
     *
     * @return PostId Post identifier value object
     */
    public function id(): PostId
    {
        return PostId::fromString($this->id);
    }

    /**
     * Returns the post title in the loaded locale.
     *
     * @return string Post title
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * Returns the post description in the loaded locale.
     *
     * @return string|null Post description
     */
    public function description(): ?string
    {
        return $this->description;
    }

    /**
     * Returns the post content in the loaded locale.
     *
     * @return string Post content
     */
    public function content(): string
    {
        return $this->content;
    }

    /**
     * Returns the post status.
     *
     * @return PostStatus Current status
     */
    public function status(): PostStatus
    {
        return $this->status;
    }

    /**
     * Returns the publication timestamp.
     *
     * @return DateTimeImmutable|null Published date or null if not published
     */
    public function publishedAt(): ?DateTimeImmutable
    {
        return $this->publishedAt;
    }

    /**
     * Commands
     */


    /**
     * Changes the post title for the specified locale.
     *
     * @param string $title New title text
     * @param Locale $locale Target locale for translation
     */
    public function changeTitle(string $title, Locale $locale): void
    {
        $this->setTranslatableLocale($locale);
        $this->title = $title;
    }

    /**
     * Changes the post description for the specified locale.
     *
     * @param string $description New description text
     * @param Locale $locale Target locale for translation
     */
    public function changeDescription(string $description, Locale $locale): void
    {
        $this->setTranslatableLocale($locale);
        $this->description = $description;
    }

    /**
     * Changes the post content for the specified locale.
     *
     * @param string $content New content text
     * @param Locale $locale Target locale for translation
     */
    public function changeContent(string $content, Locale $locale): void
    {
        $this->setTranslatableLocale($locale);
        $this->content = $content;
    }

    /**
     * Changes SEO metadata for the specified locale.
     *
     * @param SeoMetadata $seo_metadata SEO metadata entity
     * @param Locale $locale Target locale for translation
     */
    public function changeSeoMetadata(SeoMetadata $seo_metadata, Locale $locale): void
    {
        $this->setTranslatableLocale($locale);
        $this->seoMetadata = $seo_metadata;
    }

    /**
     * Publishes the post if all required fields are present.
     *
     * Sets published timestamp and changes status to PUBLISHED.
     *
     * @throws PostNotReadyForPublicationException If post cannot be published
     */
    public function publish(): void
    {
        $this->ensureCanBePublished();

        $this->publishedAt = new DateTimeImmutable();
        $this->status = PostStatus::PUBLISHED;
    }

    /**
     * Unpublishes the post and returns it to DRAFT status.
     *
     * Clears the published timestamp.
     */
    public function unpublish(): void
    {
        $this->publishedAt = null;
        $this->status = PostStatus::DRAFT;
    }

    /**
     * Archives the post and clears the published timestamp.
     */
    public function archive(): void
    {
        $this->publishedAt = null;
        $this->status = PostStatus::ARCHIVED;
    }

    /**
     * Validates that the post can be published.
     *
     * Ensures that title, content, and description are present
     * and that the post is not already published.
     *
     * @throws PostNotReadyForPublicationException If validation fails
     */
    private function ensureCanBePublished(): void
    {
        if ($this->status === PostStatus::PUBLISHED) {
            throw PostNotReadyForPublicationException::alreadyPublished();
        }

        if (empty($this->title)) {
            throw PostNotReadyForPublicationException::missingTitle();
        }

        if (empty($this->content)) {
            throw PostNotReadyForPublicationException::missingContent();
        }

        if (empty($this->description)) {
            throw PostNotReadyForPublicationException::missingDescription();
        }

    }


}
