<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryTable extends Migration
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
            'donation_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'food_type' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'quantity' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'unit' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'kg',
            ],
            'expiration_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'storage_location' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['available', 'reserved', 'distributed', 'expired'],
                'default' => 'available',
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
        $this->forge->addKey('donation_id');
        $this->forge->addKey('status');
        $this->forge->addKey('expiration_date');
        $this->forge->addKey('storage_location');
        $this->forge->createTable('inventory', true);
    }

    public function down()
    {
        $this->forge->dropTable('inventory', true);
    }
}
