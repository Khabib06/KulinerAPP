<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'place_id',
        'order_id',
        'package_name',
        'amount',
        'status'
    ];

    protected $useTimestamps = true;
}