<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Rename table zerohunger to donations (function-based name).
 */
class RenameZerohungerToDonations extends Migration
{
    public function up()
    {
        $this->forge->renameTable('zerohunger', 'donations');
    }

    public function down()
    {
        $this->forge->renameTable('donations', 'zerohunger');
    }
}
