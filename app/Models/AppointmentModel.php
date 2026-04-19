<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table            = 'appointments';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'business_id',
        'business_service_id',
        'user_id',
        'appointment_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'appointment_date',
        'appointment_time',
        'note',
        'status',
        'rejection_reason',
        'suggested_date',
        'suggested_time',
        'admin_note',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'business_id'         => 'integer',
        'business_service_id' => 'integer',
    ];

    protected $useTimestamps = true;
}
