<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EducationDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
                'unsigned'       => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'highest_education' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'university' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'college' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'percentage' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'year_of_passing' => [
                'type'       => 'YEAR',
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

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('education_details');
    }

    public function down()
    {
        $this->forge->dropTable('education_details');
    }
}
