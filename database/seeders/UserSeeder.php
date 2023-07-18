<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create multiple users with sample data
        $users = [
            
            [
                'pin' => '406976928',
                'name' => 'محمود سمور',
                'phone' => '0599025549',
                'status' => 'in-active',
            ],
            // Add more users here...
        ];

        foreach ($users as $userData) {
            User::create([
                'pin' => $userData['pin'],
                'name' => $userData['name'],
                'phone' => $userData['phone'],
                'status' => $userData['status'],
            ]);
        }
    }
}
