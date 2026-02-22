<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropRecipientsContactInfo extends Migration
{
    public function up()
    {
        // Remove legacy combined contact_info column; we now use phone/email/notes
        $this->forge->dropColumn('recipients', 'contact_info');
    }

    public function down()
    {
        // Restore contact_info as a nullable TEXT column
        $fields = [
            'contact_info' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'email',
            ],
        ];

        $this->forge->addColumn('recipients', $fields);
    }
}

