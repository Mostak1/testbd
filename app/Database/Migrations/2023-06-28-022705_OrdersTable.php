<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class OrdersTable extends Migration
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

            'customer_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'product_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'total' => [
                'type' => 'FLOAT',
                'constraint' => '10,2',
                'null' => true,
            ],
            'discount' => [
                'type' => 'FLOAT',
                'constraint' => '6,2',
                'null' => true,
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'comment' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'payment' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tranxid' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'b_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            's_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ]

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('Orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
