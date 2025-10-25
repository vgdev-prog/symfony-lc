<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Persistence\Doctrine;

use App\Blog\Domain\Entity\Post;
use App\Blog\Domain\Repository\PostRepositoryInterface;
use App\Blog\Domain\ValueObject\Post\PostId;
use App\Common\Domain\Enum\Locale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Gedmo\Translatable\Query\TreeWalker\TranslationWalker;

/**
 * Doctrine implementation of PostRepositoryInterface.
 *
 * Provides persistence operations for Post entities with Gedmo Translatable support.
 * All query methods automatically load translations in the specified locale.
 *
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Finds a post by ID with translations loaded in the specified locale.
     *
     * Uses Gedmo TranslationWalker to automatically load translatable fields
     * in the requested locale without requiring EntityManager::refresh().
     *
     * @param PostId $id Post identifier
     * @param Locale $locale Target locale for translations
     * @return Post|null Post entity with translations or null if not found
     */
    public function findById(PostId $id, Locale $locale): ?Post
    {
        return $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', $id->value())
            ->getQuery()
            ->setHint(
                TranslationWalker::HINT_TRANSLATABLE_LOCALE,
                $locale->value
            )
            ->getOneOrNullResult();
    }

    /**
     * Finds all posts with translations in the specified locale.
     *
     * @param Locale $locale Target locale for translations
     * @return Post[] Array of Post entities
     */
    public function findAll(Locale $locale): array
    {
        return $this->createQueryBuilder('p')
            ->getQuery()
            ->setHint(
                TranslationWalker::HINT_TRANSLATABLE_LOCALE,
                $locale->value
            )
            ->getResult();
    }

    /**
     * Persists a post entity and flushes changes to the database.
     *
     * @param Post $post Post entity to save
     */
    public function save(Post $post): void
    {
        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush();
    }

    /**
     * Removes a post entity and flushes changes to the database.
     *
     * @param Post $post Post entity to remove
     */
    public function remove(Post $post): void
    {
        $this->getEntityManager()->remove($post);
        $this->getEntityManager()->flush();
    }
}
