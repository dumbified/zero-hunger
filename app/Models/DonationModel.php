<?php

namespace App\Models;

use CodeIgniter\Model;

class DonationModel extends Model
{
    protected $table = 'donations';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'full_name',
        'phone',
        'email',
        'food_type',
        'estimated_quantity',
        'preferred_datetime',
        'pickup_address',
        'notes',
        'status',
        'assigned_to',
        'assigned_driver',
        'scheduled_time',
        'internal_notes',
        'status_history',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
