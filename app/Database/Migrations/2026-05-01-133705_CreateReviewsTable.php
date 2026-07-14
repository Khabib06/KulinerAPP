<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReviewsTable extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'user_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
        ],
        'place_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
        ],
        'rating' => [
            'type' => 'INT',
            'constraint' => 1,
        ],
        'komentar' => [
            'type' => 'TEXT',
        ],
        'created_at' => [
            'type' => 'DATETIME',
            'null' => true,
        ],
        'updated_at' => [
            'type' => 'DATETIME',
            'null' => true,
        ],
    ]);

    $this->forge->addKey('id', true);

    $this->forge->addForeignKey(
        'user_id',
        'users',
        'id',
        'CASCADE',
        'CASCADE'
    );

    $this->forge->addForeignKey(
        'place_id',
        'places',
        'id',
        'CASCADE',
        'CASCADE'
    );

    $this->forge->createTable('reviews');
}

    public function down()
    {
        //
    }
}
