<?php

declare(strict_types=1);

return [
    'strava' => [
        'url' => env('STRAVA_URL', 'https://www.strava.com/'),
        'apiUrl' => env('STRAVA_API_URL', 'https://www.strava.com/'),
        'client_id' => env('STRAVA_CLIENT_ID'),
        'client_secret' => env('STRAVA_CLIENT_SECRET'),
        'redirect_uri' => env('STRAVA_REDIRECT_URI'),
        'timeout' => env('STRAVA_TIMEOUT', 10),
        'scope' => env('STRAVA_SCOPE', 'read,activity:read_all,profile:read_all'),
    ],
];

