<?php

declare(strict_types=1);

namespace App\Infrastructure\Framework\Exceptions\Renderer;

use Spiral\Boot\Environment\DebugMode;
use Spiral\Exceptions\ExceptionRendererInterface;
use Spiral\Exceptions\Verbosity;

final readonly class ApiJsonRenderer implements ExceptionRendererInterface
{
    public const FORMATS = ['application/json', 'json'];

    public function __construct(
        private DebugMode $debugMode,
    ) {}

    public function render(
        \Throwable $exception,
        ?Verbosity $verbosity = Verbosity::BASIC,
        ?string $format = null,
    ): string {
        $data = [
            'message' => $exception->getMessage(),
        ];

        if ($this->debugMode->isEnabled()) {
            $data['trace'] = $exception->getTraceAsString();
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function canRender(string $format): bool
    {
        return \in_array($format, self::FORMATS, true);
    }
}
