<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Ensures status_history on zerohunger is TEXT for MySQL compatibility.
 * Safe to run if the column was created as JSON (000003 before edit) or already TEXT.
 */
class AlterZerohungerStatusHistoryToText extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('zerohunger', [
            'status_history' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('zerohunger', [
            'status_history' => [
                'type' => 'JSON',
                'null' => true,
            ],
        ]);
    }
}
