<?php

declare(strict_types=1);

namespace App\Blog\Domain\Repository;

use App\Blog\Domain\Entity\Post;
use App\Blog\Domain\ValueObject\Post\PostId;
use App\Common\Domain\Enum\Locale;

/**
 * Repository interface for Post aggregate root.
 *
 * Defines domain operations for persisting and retrieving Post entities.
 * All query methods support locale parameter for Gedmo Translatable integration.
 */
interface PostRepositoryInterface
{
    /**
     * Finds a post by its identifier with translations in specified locale.
     *
     * @param PostId $id Post identifier
     * @param Locale $locale Locale for translatable fields
     * @return Post|null Post entity or null if not found
     */
    public function findById(PostId $id, Locale $locale): ?Post;

    /**
     * Finds all posts with translations in specified locale.
     *
     * @param Locale $locale Locale for translatable fields
     * @return Post[] Array of Post entities
     */
    public function findAll(Locale $locale): array;

    /**
     * Persists a post entity to the database.
     *
     * @param Post $post Post entity to save
     */
    public function save(Post $post): void;

    /**
     * Removes a post entity from the database.
     *
     * @param Post $post Post entity to remove
     */
    public function remove(Post $post): void;
}
