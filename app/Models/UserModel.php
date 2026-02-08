<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'username',
        'email',
        'password_hash',
        'role',
        'status',
        'last_login',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password_hash']) && !empty($data['data']['password_hash'])) {
            // Only hash if it's not already hashed (check length)
            if (strlen($data['data']['password_hash']) < 60) {
                $data['data']['password_hash'] = password_hash($data['data']['password_hash'], PASSWORD_DEFAULT);
            }
        }
        return $data;
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function findByUsername(string $username)
    {
        return $this->where('username', $username)
            ->where('status', 'active')
            ->first();
    }

    public function findByEmail(string $email)
    {
        return $this->where('email', $email)
            ->where('status', 'active')
            ->first();
    }

    public function updateLastLogin(int $userId)
    {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }
}
