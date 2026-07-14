<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 2,
                'place_id' => 1,
                'rating' => 5,
                'komentar' => 'Sotonya enak banget, kuahnya mantap!',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 3,
                'place_id' => 1,
                'rating' => 4,
                'komentar' => 'Murah dan porsi lumayan.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 2,
                'place_id' => 2,
                'rating' => 5,
                'komentar' => 'Es tehnya seger banget, cocok buat panas.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 3,
                'place_id' => 3,
                'rating' => 4,
                'komentar' => 'Ayam geprek pedesnya nendang.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('reviews')->insertBatch($data);
    }
}