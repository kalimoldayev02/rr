<?php

declare(strict_types=1);

use App\Application\UseCases\Command\Athlete\SyncAthleteWithClubs;

return [
    SyncAthleteWithClubs\SyncAthleteWithClubsCommand::class => [
        'handler' => SyncAthleteWithClubs\SyncAthleteWithClubsCommandHandler::class,
    ],
];
