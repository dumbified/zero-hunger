<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateZerohungerTable extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'confirmed', 'scheduled', 'picked_up', 'completed', 'cancelled'],
                'default' => 'pending',
                'after' => 'notes',
            ],
            'assigned_to' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
                'after' => 'status',
            ],
            'assigned_driver' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
                'after' => 'assigned_to',
            ],
            'scheduled_time' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'assigned_driver',
            ],
            'internal_notes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'scheduled_time',
            ],
            'status_history' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'internal_notes',
            ],
        ];

        $this->forge->addColumn('zerohunger', $fields);
        $this->forge->addKey('status');
        $this->forge->addKey('assigned_to');
        $this->forge->addKey('assigned_driver');
        $this->forge->addKey('scheduled_time');
    }

    public function down()
    {
        $this->forge->dropColumn('zerohunger', ['status', 'assigned_to', 'assigned_driver', 'scheduled_time', 'internal_notes', 'status_history']);
    }
}
