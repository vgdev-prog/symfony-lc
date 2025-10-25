<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

use App\Blog\Domain\Entity\Category;
use App\Blog\Domain\Entity\Post;
use App\Blog\Domain\Entity\Tag;
use App\Common\Domain\Attribute\EntityType;
use App\Common\Domain\Exception\InvalidEntityTypeException;
use ReflectionClass;
use ReflectionException;

class EntityTypeMap
{
    /**
     * @var array<string, class-string>
     */
    private static $registry = [];


    /**
     * @throws ReflectionException
     */
    public static function discoverFromClasses(array $entityClasses): void
    {
        foreach ($entityClasses as $class) {
            $reflection = new ReflectionClass($class);
            $attributes = $reflection->getAttributes(EntityType::class);

            if (empty($attributes)) {
                continue;
            }

            /** @var EntityType $entityType */
            $entityType = $attributes[0]->newInstance();
            self::$registry[$entityType->type] = $class;
        }

    }

    public static function register(string $type, string $class): void
    {
        self::$registry[$type] = $class;
    }


    public static function getClass(string $type): string
    {
        if (!isset(self::$registry[$type])) {
            throw InvalidEntityTypeException::entityTypeNotFound($type);
        }

        return self::$registry[$type];
    }

    public static function getType(string $class): string
    {
        $type = array_search($class, self::$registry, true);

        if ($type === false) {
            throw InvalidEntityTypeException::entityClassNotFound($class);
        }

        return $type;
    }

    public static function hasType(string $type): bool
    {
        return isset(self::$registry[$type]);
    }


}
