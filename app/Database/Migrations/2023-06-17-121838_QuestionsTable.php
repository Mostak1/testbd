<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class QuestionsTable extends Migration
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
            'subject_id' => [
                'type'       => 'int',
                'unsigned'       => true,
                'constraint' => 11,

            ],
            'board_id' => [
                'type'       => 'int',
                'unsigned'       => true,
                'constraint' => 11,
            ],
            'zilla_id' => [
                'type'       => 'int',
                'unsigned'       => true,
                'constraint' => 11,
            ],
            'thana_id' => [
                'type'       => 'int',
                'unsigned'       => true,
                'constraint' => 11,
            ],
            'institute_id' => [
                'type'       => 'int',
                'unsigned'       => true,
                'constraint' => 11,
            ],
            'year' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'q_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ]

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('questions');
    }

    public function down()
    {
        $this->forge->dropTable('questions');
    }
}
