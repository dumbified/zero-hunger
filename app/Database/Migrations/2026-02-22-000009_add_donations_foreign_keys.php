<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDonationsForeignKeys extends Migration
{
    public function up()
    {
        // Add foreign keys for assigned_to and assigned_driver
        // Note: The table is now named 'donations' (renamed from 'zerohunger')
        
        // assigned_to -> users.id
        $this->db->query('ALTER TABLE donations ADD CONSTRAINT fk_donations_assigned_to FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE');
        
        // assigned_driver -> users.id
        $this->db->query('ALTER TABLE donations ADD CONSTRAINT fk_donations_assigned_driver FOREIGN KEY (assigned_driver) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE donations DROP FOREIGN KEY fk_donations_assigned_to');
        $this->db->query('ALTER TABLE donations DROP FOREIGN KEY fk_donations_assigned_driver');
    }
}
