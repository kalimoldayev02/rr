<?php

declare(strict_types=1);

return [
    'secret' => env('JWT_SECRET', ''),
    'algorithm' => env('JWT_ALGORITHM', 'HS256'),
    'ttl' => (int) env('JWT_ACCESS_TOKEN_TTL', 3600),
];
