<?php

declare(strict_types=1);

use App\Infrastructure\Framework\Exceptions\Handler;
use App\Infrastructure\Framework\Kernel;
use Spiral\Core\Container;
use Spiral\Core\Options;

\mb_internal_encoding('UTF-8');
\error_reporting(E_ALL ^ E_DEPRECATED);
\ini_set('display_errors', 'stderr');

require __DIR__ . '/vendor/autoload.php';

$options = new Options();
$options->allowSingletonsRebinding = false;
$options->validateArguments = false;
$container = new Container(options: $options);
$app = Kernel::create(
    directories: [
        'root' => __DIR__,
        'app' => __DIR__ . '/src',
        'config' => __DIR__ . '/config',
        'migrations' => __DIR__ . '/database/migrations',
    ],
    exceptionHandler: Handler::class,
    container: $container,
)->run();

if ($app === null) {
    exit(255);
}

$code = (int) $app->serve();
exit($code);
