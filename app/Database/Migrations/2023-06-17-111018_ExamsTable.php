<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class ExamsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'exam_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ]

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('exams');
    }

    public function down()
    {
        $this->forge->dropTable('exams');
    }
}
