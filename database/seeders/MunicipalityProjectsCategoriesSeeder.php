<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MunicipalityProjectsCategory;

class MunicipalityProjectsCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'مشاريع تم تنفيذها',
            'مشاريع حالية',
            'مشاريع مستقبلية',
            'مشاريع تحتاج تمويل'
        ];

        foreach ($categories as $category) {
            MunicipalityProjectsCategory::create([
                'name' => $category,
            ]);
        }
    }
}
