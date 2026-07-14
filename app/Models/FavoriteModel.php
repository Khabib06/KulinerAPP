<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoriteModel extends Model
{
    protected $table = 'favorites';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'place_id'
    ];

    protected $useTimestamps = false;
}