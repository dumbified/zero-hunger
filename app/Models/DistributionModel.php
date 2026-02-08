<?php

namespace App\Models;

use CodeIgniter\Model;

class DistributionModel extends Model
{
    protected $table = 'distributions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'recipient_id',
        'items',
        'date',
        'delivery_method',
        'notes',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getDistributionsByRecipient(int $recipientId)
    {
        return $this->where('recipient_id', $recipientId)
            ->orderBy('date', 'DESC')
            ->findAll();
    }
}
