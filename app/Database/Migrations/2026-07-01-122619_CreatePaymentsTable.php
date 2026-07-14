<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],

            'place_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],

            'order_id' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],

            'package_name' => [
                'type' => 'VARCHAR',
                'constraint' => 30
            ],

            'amount' => [
                'type' => 'INT'
            ],

            'status' => [
                'type' => 'ENUM',
                'constraint' => [
                    'pending',
                    'paid',
                    'failed'
                ],
                'default' => 'pending'
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]

        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey(
            'place_id',
            'places',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('payments');
    }

    public function down()
    {
        $this->forge->dropTable('payments');
    }
}