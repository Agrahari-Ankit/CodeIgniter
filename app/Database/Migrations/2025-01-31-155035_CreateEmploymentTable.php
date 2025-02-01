<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmploymentTable extends Migration
{
    public function up() {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'user_id'           => ['type' => 'INT', 'constraint' => 11],
            'company_name'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'designation'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'years_experience'  => ['type' => 'INT', 'constraint' => 3],
            'location'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('employment_details');
    }

    public function down() {
        $this->forge->dropTable('employment_details');
    }
}
