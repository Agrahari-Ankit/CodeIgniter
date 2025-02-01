<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up(){
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'first_name'  => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'last_name'   => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'email'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'unique'         => true,
            ],
            'password'    => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'profile_image'    => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'role'        => [
                'type'           => 'ENUM',
                'constraint'     => ['admin', 'customer'],
                'default'        => 'customer',
            ],
            'last_login'  => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'created_at'  => [
            'type'           => 'DATETIME',
            'null'           => true,  
            ],
            'updated_at'  => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],

        ]);
        
        
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
