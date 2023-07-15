<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Admin::create([
            'name' => 'محمد أبو طير',
            'email' => 'moh2015moh21415@gmail.com',
            'password' => bcrypt('12345'),
            'role_id' => "1"
        ]);


    }

}
