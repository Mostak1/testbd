<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldToQuestions extends Migration
{
    public function up()
    {
        $this->forge->addColumn('questions', [
            'hot' => [
                'type' => 'int',
                'constraint' => 2, // Replace with your desired constraint
                'null' => true,
                'after' => 'q_image' // Replace with the desired position
            ]
        ]);
    }

    public function down()
    {
        //
    }
}
