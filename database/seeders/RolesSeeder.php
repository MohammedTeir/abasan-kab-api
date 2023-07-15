<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
      /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'مدير النظام'],
            ['name' => 'مدير محتوى'],
            ['name' => 'خدمات جمهور'],
            // Add more roles as needed
        ];

        Role::insert($roles);
    }
}
