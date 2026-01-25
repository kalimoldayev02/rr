<?php

declare(strict_types=1);

namespace App;

use Cycle\Migrations\Migration;

class CreateDistanceReferencesMigration extends Migration
{
    private const string TABLE_NAME = 'distance_references';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('id', 'uuid')
            ->addColumn('distance', 'float')
            ->addColumn('distance_type', 'string')
            ->setPrimaryKeys(['id'])
            ->create();
    }

    public function down(): void
    {
        $this->table(self::TABLE_NAME)->drop();
    }
}
