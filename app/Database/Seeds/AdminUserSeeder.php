<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        
        // Create default admin user
        $data = [
            'username' => 'admin',
            'email' => 'admin@zerohunger.org',
            'password_hash' => 'admin123', // Will be hashed automatically
            'role' => 'super_admin',
            'status' => 'active',
        ];

        $userModel->insert($data);
    }
}
