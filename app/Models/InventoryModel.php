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

    /**
     * Set status to 'expired' for all items whose expiration_date is in the past.
     * Call this when loading inventory so status stays in sync.
     */
    public function markExpiredItems(): int
    {
        $today = date('Y-m-d');
        $builder = $this->builder();
        $builder->where('expiration_date <', $today);
        $builder->where('status !=', 'expired');
        $builder->set('status', 'expired');
        $builder->set('updated_at', date('Y-m-d H:i:s'));
        $builder->update();
        return $this->db->affectedRows();
    }

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
            ->orderBy('expiration_date', 'ASC')
            ->findAll();
    }
}
