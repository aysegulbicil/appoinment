<?php

namespace App\Models;

use CodeIgniter\Model;

class BusinessServiceModel extends Model
{
    protected $table            = 'business_services';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'business_id',
        'title',
        'description',
        'duration_minutes',
        'price',
        'status',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'business_id' => 'integer',
    ];

    protected $useTimestamps = true;
}
