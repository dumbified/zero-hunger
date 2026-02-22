<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateRecipientsAddContacts extends Migration
{
    public function up()
    {
        // Add separate contact fields to recipients
        $fields = [
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 32,
                'null'       => true,
                'after'      => 'type',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'phone',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'service_area',
            ],
        ];

        $this->forge->addColumn('recipients', $fields);
    }

    public function down()
    {
        // Remove the new columns (keep old contact_info for backward compatibility)
        $this->forge->dropColumn('recipients', ['phone', 'email', 'notes']);
    }
}

