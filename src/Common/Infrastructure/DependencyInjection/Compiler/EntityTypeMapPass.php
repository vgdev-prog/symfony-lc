<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\DependencyInjection\Compiler;

use App\Common\Domain\ValueObject\EntityTypeMap;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;

class EntityTypeMapPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        $projectDir = $container->getParameter('kernel.project_dir');
        $entityClasses = $this->findEntityClasses($projectDir);

        EntityTypeMap::discoverFromClasses($entityClasses);

    }

    /**
     * @return array<class-string>
     */
    private function findEntityClasses(string $projectDir): array
    {
        $classes = [];
        $srcDir = $projectDir . '/src';

        $finder = new Finder();
        $finder->files()->in($srcDir)->name('*.php')->contains('#\[ORM\\\\Entity');

        foreach ($finder as $file) {
            $relativePath = str_replace($srcDir, '', $file->getRealPath());
            $relativePath = str_replace('.php', '', $relativePath);
            $className = 'App' . str_replace('/', '\\', $relativePath);

            if (class_exists($className)) {
                $classes[] = $className;
            }
        }

        return $classes;
    }

}
