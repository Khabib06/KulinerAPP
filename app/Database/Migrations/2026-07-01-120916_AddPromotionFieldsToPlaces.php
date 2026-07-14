<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPromotionFieldsToPlaces extends Migration
{
    public function up()
    {
        $fields = [

            'is_promoted' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'after' => 'status'
            ],

            'promotion_package' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
                'after' => 'is_promoted'
            ],

            'promotion_price' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'after' => 'promotion_package'
            ],

            'promotion_status' => [
                'type' => 'ENUM',
                'constraint' => [
                    'none',
                    'pending',
                    'paid'
                ],
                'default' => 'none',
                'after' => 'promotion_price'
            ],

            'promotion_end' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'promotion_status'
            ]

        ];

        $this->forge->addColumn('places', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('places', [
            'is_promoted',
            'promotion_package',
            'promotion_price',
            'promotion_status',
            'promotion_end'
        ]);
    }
}