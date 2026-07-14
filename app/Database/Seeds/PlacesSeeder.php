<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PlacesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'category_id' => 1,
                'nama_tempat' => 'Soto Pak Slamet',
                'alamat' => 'Jl. Imam Bonjol, Semarang',
                'deskripsi' => 'Soto khas dengan kuah gurih dan ayam suwir.',
                'foto' => 'soto.jpg',
                'latitude' => '-6.9823',
                'longitude' => '110.4091',
                'status' => 'approved',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'category_id' => 2,
                'nama_tempat' => 'Es Teh Nusantara',
                'alamat' => 'Jl. Tembalang Raya',
                'deskripsi' => 'Minuman segar dengan berbagai varian rasa.',
                'foto' => 'esteh.jpg',
                'latitude' => '-6.9830',
                'longitude' => '110.4100',
                'status' => 'approved',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'category_id' => 1,
                'nama_tempat' => 'Ayam Geprek Dower',
                'alamat' => 'Dekat UDINUS Kampus',
                'deskripsi' => 'Ayam crispy pedas level neraka.',
                'foto' => 'geprek.jpg',
                'latitude' => '-6.9815',
                'longitude' => '110.4085',
                'status' => 'approved',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('places')->insertBatch($data);
    }
}