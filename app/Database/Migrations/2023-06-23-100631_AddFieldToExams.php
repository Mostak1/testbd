<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldToExams extends Migration
{
    public function up()
    {
        $this->forge->addColumn('exams', [
            'url' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'after' => 'exam_name' // Replace with the desired position
            ]
        ]);
    }

    public function down()
    {
        //
    }
}
