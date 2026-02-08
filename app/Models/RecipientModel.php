<?php

namespace App\Models;

use CodeIgniter\Model;

class RecipientModel extends Model
{
    protected $table = 'recipients';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'name',
        'type',
        'contact_info',
        'address',
        'service_area',
        'status',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
