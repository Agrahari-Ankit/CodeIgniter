<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerUserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'first_name'  => 'Ankit',
                'last_name'   => 'Kumar',
                'email'       => 'ankit@gmail.com',
                'password'    => password_hash('password123', PASSWORD_DEFAULT),
                'role'        => 'customer',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'first_name'  => 'Namit',
                'last_name'   => 'Kumar',
                'email'       => 'namit@gmail.com',
                'password'    => password_hash('password123', PASSWORD_DEFAULT),
                'role'        => 'customer',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'first_name'  => 'Alice',
                'last_name'   => 'Brown',
                'email'       => 'alice.brown@gmail.com',
                'password'    => password_hash('password123', PASSWORD_DEFAULT),
                'role'        => 'customer',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'first_name'  => 'Bob',
                'last_name'   => 'Taylor',
                'email'       => 'bob@gmail.com',
                'password'    => password_hash('password123', PASSWORD_DEFAULT),
                'role'        => 'customer',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'first_name'  => 'Charlie',
                'last_name'   => 'Johnson',
                'email'       => 'charlie.johnson@gmail.com',
                'password'    => password_hash('password123', PASSWORD_DEFAULT),
                'role'        => 'customer',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert data into the users table
        $this->db->table('users')->insertBatch($data);
    }
}
