<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FavoritesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 2,
                'place_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 3,
                'place_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 2,
                'place_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('favorites')->insertBatch($data);
    }
}