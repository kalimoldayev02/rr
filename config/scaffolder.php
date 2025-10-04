<?php

declare(strict_types=1);

use Spiral\Scaffolder\Declaration;

return [
    'namespace' => 'App',
    'directory' => 'src',

    'declarations' => [
        Declaration\BootloaderDeclaration::TYPE => [
            'namespace' => 'Application\\Infrastructure\\Framework\\Bootloader',
        ],
        Declaration\ConfigDeclaration::TYPE => [
            'namespace' => 'Application\\Config',
        ],
        Declaration\ControllerDeclaration::TYPE => [
            'namespace' => 'Endpoint\\Http\\Controllers',
        ],
        Declaration\FilterDeclaration::TYPE => [
            'namespace' => 'Endpoint\\Http\\Requests',
            'postfix' => 'Request',
        ],
        Declaration\MiddlewareDeclaration::TYPE => [
            'namespace' => 'Endpoint\\Http\\Middlewares',
        ],
        Declaration\CommandDeclaration::TYPE => [
            'namespace' => 'Endpoint\\Consoles',
        ],
        Declaration\JobHandlerDeclaration::TYPE => [
            'namespace' => 'Endpoint\\Jobs',
        ],
    ],
];
