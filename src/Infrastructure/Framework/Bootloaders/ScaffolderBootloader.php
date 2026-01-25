<?php

declare(strict_types=1);

namespace App\Infrastructure\Framework\Bootloaders;

use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Cycle\Scaffolder\Declaration;
use Spiral\Scaffolder\Bootloader\ScaffolderBootloader as BaseScaffolderBootloader;

final class ScaffolderBootloader extends Bootloader
{
    public function init(BaseScaffolderBootloader $scaffolder): void
    {
        // Entities
        $scaffolder->addDeclaration(Declaration\Entity\AnnotatedDeclaration::TYPE, [
            'namespace' => 'Infrastructure\\Persistence\\CycleORM\\Entities',
            'postfix' => 'CycleORMEntity',
            'options' => [
                'annotated' => Declaration\Entity\AnnotatedDeclaration::class,
            ],
        ]);

        // Repositories
        $scaffolder->addDeclaration(Declaration\RepositoryDeclaration::TYPE, [
            'namespace' => 'Infrastructure\\Persistence\\CycleORM\\Repositories',
            'postfix' => 'CycleORMRepository',
            'class' => Declaration\RepositoryDeclaration::class,
        ]);
    }
}
