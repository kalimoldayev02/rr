<?php

declare(strict_types=1);

namespace App;

use Cycle\Migrations\Migration;

class CreateActivityDetailsTableMigration extends Migration
{
    private const string TABLE_NAME = 'activity_details';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('activity_id', 'uuid')
            ->addColumn('splits', 'json', ['nullable' => true, 'default' => null])
            ->addColumn('laps', 'json', ['nullable' => true, 'default' => null])
            ->setPrimaryKeys(['activity_id'])
            ->addForeignKey(['activity_id'], 'activities', ['id'], [
                'cascade' => true,
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->create();
    }

    public function down(): void
    {
        $this->table(self::TABLE_NAME)->drop();
    }
}
