<?php

declare(strict_types=1);

namespace App\Blog\Domain\Entity;

use App\Blog\Domain\ValueObject\Post\PostId;
use App\Blog\Domain\ValueObject\Post\PostStatus;
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
    private ?\DateTimeImmutable $publishedAt = null;

    #[ORM\Column(length: 255)]
    private PostStatus $status;

    public function __construct(PostId $id)
    {
        $this->id = $id->value();
    }

    public static function create():self
    {
        return new self(PostId::generate());
    }

   public function id(): PostId
   {
       return PostId::fromString($this->id);
   }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
