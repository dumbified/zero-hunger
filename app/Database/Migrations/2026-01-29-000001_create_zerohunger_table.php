<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateZerohungerTable extends Migration
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
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'food_type' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'estimated_quantity' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
            ],
            'preferred_datetime' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
            ],
            'pickup_address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->addKey('created_at');
        $this->forge->createTable('zerohunger', true);
    }

    public function down()
    {
        $this->forge->dropTable('zerohunger', true);
    }
}
