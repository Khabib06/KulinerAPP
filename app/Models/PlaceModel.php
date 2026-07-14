<?php

namespace App\Models;

use CodeIgniter\Model;

class PlaceModel extends Model
{
    protected $table = 'places';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'category_id',
        'nama_tempat',
        'alamat',
        'deskripsi',
        'foto',
        'latitude',
        'longitude',
        'status',
        'is_promoted',
        'promotion_package',
        'promotion_price',
        'promotion_status',
        'promotion_end'
    ];

    protected $useTimestamps = true;
}