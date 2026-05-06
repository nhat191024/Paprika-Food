<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['en' => 'Main Course',  'el' => 'Κύριο Πιάτο',   'slug' => 'main-course',  'children' => [
                ['en' => 'Rice',     'el' => 'Ρύζι',           'slug' => 'rice'],
                ['en' => 'Noodles', 'el' => 'Νουντλς',        'slug' => 'noodles'],
                ['en' => 'Vermicelli', 'el' => 'Βερμιτσέλι',  'slug' => 'vermicelli'],
            ]],
            ['en' => 'Drinks',       'el' => 'Ποτά',           'slug' => 'drinks',       'children' => [
                ['en' => 'Soda',     'el' => 'Αναψυκτικό',     'slug' => 'soda'],
                ['en' => 'Milk Tea', 'el' => 'Τσάι Γάλακτος',  'slug' => 'milk-tea'],
                ['en' => 'Smoothie', 'el' => 'Σμούθι',         'slug' => 'smoothie'],
            ]],
            ['en' => 'Combo',        'el' => 'Σετ',            'slug' => 'combo',        'children' => []],
            ['en' => 'Dessert',      'el' => 'Επιδόρπιο',      'slug' => 'dessert',      'children' => [
                ['en' => 'Ice Cream', 'el' => 'Παγωτό',        'slug' => 'ice-cream'],
                ['en' => 'Cake',      'el' => 'Κέικ',           'slug' => 'cake'],
            ]],
        ];

        foreach ($categories as $cat) {
            $parent = Category::firstOrCreate(
                ['slug' => $cat['slug']],
                ['name' => ['en' => $cat['en'], 'el' => $cat['el']], 'parent_id' => null]
            );

            foreach ($cat['children'] as $child) {
                Category::firstOrCreate(
                    ['slug' => $child['slug']],
                    ['name' => ['en' => $child['en'], 'el' => $child['el']], 'parent_id' => $parent->id]
                );
            }
        }
    }
}
