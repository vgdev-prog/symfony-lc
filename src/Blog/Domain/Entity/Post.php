<?php

declare(strict_types=1);

namespace App\Blog\Domain\Entity;

use App\Blog\Domain\ValueObject\Post\PostId;
use App\Blog\Domain\ValueObject\Post\PostStatus;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Post
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private string $id;

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
