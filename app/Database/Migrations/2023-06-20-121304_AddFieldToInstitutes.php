<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldToInstitutes extends Migration
{
    public function up()
    {
        $this->forge->addColumn('institutes', [
            'district_id' => [
                'type' => 'int',
                'constraint' => 11, // Replace with your desired constraint
                'null' => false,
                'after' => 'id' // Replace with the desired position
            ]
        ]);
    }

    public function down()
    {
        //
    }
}
