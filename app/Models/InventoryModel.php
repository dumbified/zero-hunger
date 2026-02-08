<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryModel extends Model
{
    protected $table = 'inventory';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'donation_id',
        'food_type',
        'quantity',
        'unit',
        'expiration_date',
        'storage_location',
        'status',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getExpiringItems(int $days = 7)
    {
        $today = date('Y-m-d');
        $futureDate = date('Y-m-d', strtotime("+{$days} days"));

        return $this->where('expiration_date >=', $today)
            ->where('expiration_date <=', $futureDate)
            ->where('status', 'available')
            ->orderBy('expiration_date', 'ASC')
            ->findAll();
    }

    public function getExpiredItems()
    {
        return $this->where('expiration_date <', date('Y-m-d'))
            ->where('status', 'available')
            ->orderBy('expiration_date', 'ASC')
            ->findAll();
    }
}
