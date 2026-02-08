<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDistributionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'recipient_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'items' => [
                'type' => 'JSON',
            ],
            'date' => [
                'type' => 'DATE',
            ],
            'delivery_method' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('recipient_id');
        $this->forge->addKey('date');
        $this->forge->createTable('distributions', true);
    }

    public function down()
    {
        $this->forge->dropTable('distributions', true);
    }
}
