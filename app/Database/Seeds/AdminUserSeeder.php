<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(){
        $data = [
            'first_name'  => 'Admin',
            'last_name'   => 'User',
            'email'       => 'admin@gmail.com',
            'password'    => password_hash('admin@123', PASSWORD_DEFAULT), // Encrypt password
            'role'        => 'admin',
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        // Insert data into the users table
        $this->db->table('users')->insert($data);
    }
}
