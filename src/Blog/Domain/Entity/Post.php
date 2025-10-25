<?php

declare(strict_types=1);

namespace App\Blog\Domain\Entity;

use App\Blog\Domain\ValueObject\Post\PostId;
use App\Blog\Domain\ValueObject\Post\PostStatus;
use App\Common\Domain\Entity\Model;
use App\Common\Domain\Locale;
use App\Common\Domain\Trait\Translatable;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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

    public function __construct(PostId $id, PostStatus $status)
    {
        $this->id = $id->value();
        $this->status = $status;
    }

    public static function create(): self
    {
        return new self(
            id: PostId::generate(),
            status: PostStatus::DRAFT
        );
    }

    public function id(): PostId
    {
        return PostId::fromString($this->id);
    }

    public function changeTitle(string $title, Locale $locale): void
    {
        $this->setTranslatableLocale($locale);
        $this->title = $title;
    }

    public function changeDescription(string $description): void
    {
        $this->description = $description;
    }

    public function publish(): void
    {
      $this->publishedAt = new DateTimeImmutable();
      $this->status = PostStatus::PUBLISHED;
    }

    public function unpublish():void
    {
        $this->publishedAt = null;
        $this->status = PostStatus::DRAFT;
    }

    public function archive(): void
    {
        $this->publishedAt = null;
        $this->status = PostStatus::ARCHIVED;
    }

}
