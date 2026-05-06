<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $provinces = [
            'Germany' => ['Berlin', 'Munich', 'Hamburg', 'Cologne', 'Frankfurt'],
        ];

        foreach ($provinces as $provinceName => $districts) {
            $province = Location::firstOrCreate(['name' => $provinceName, 'parent_id' => null]);

            foreach ($districts as $districtName) {
                Location::firstOrCreate(['name' => $districtName, 'parent_id' => $province->id]);
            }
        }
    }
}
