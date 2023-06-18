<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InstitutesTable extends Migration
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
            'thana_id'   => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'url'  => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('institutes');
    }

    public function down()
    {
        $this->forge->dropTable('institutes');
    }
}
