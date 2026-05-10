<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ComboGroup;
use App\Models\ComboGroupItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $demoImage = public_path('images/demo.jpg');
        $hasImage = File::exists($demoImage);

        $rices = Category::query()->where('slug', 'rice')->first()
            ?? Category::query()->where('slug', 'main-course')->first();
        $drinks = Category::query()->where('slug', 'soda')->first()
            ?? Category::query()->where('slug', 'drinks')->first();
        $comboCategory = Category::query()->where('slug', 'combo')->first();

        // --- Regular products ---
        $regularProducts = [
            ['slug' => 'crispy-chicken-rice', 'name' => ['en' => 'Crispy Chicken Rice', 'el' => 'Τραγανό Κοτόπουλο με Ρύζι'], 'desc' => ['en' => 'Chicken rice with crispy skin.', 'el' => 'Ρύζι με κοτόπουλο τραγανό.'], 'price' => 55000, 'category' => $rices],
            ['slug' => 'pork-chop-rice',      'name' => ['en' => 'Pork Chop Rice',        'el' => 'Ρύζι με Παϊδάκι Χοιρινό'],  'desc' => ['en' => 'Rice with grilled pork chop.', 'el' => 'Ρύζι με ψητό παϊδάκι.'],     'price' => 60000, 'category' => $rices],
            ['slug' => 'pepsi-can',           'name' => ['en' => 'Pepsi Can',              'el' => 'Κουτί Pepsi'],               'desc' => ['en' => 'Chilled Pepsi can.', 'el' => 'Κρύο κουτί Pepsi.'],                   'price' => 15000, 'category' => $drinks],
            ['slug' => '7up-can',             'name' => ['en' => '7Up Can',                'el' => 'Κουτί 7Up'],                 'desc' => ['en' => 'Chilled 7Up can.', 'el' => 'Κρύο κουτί 7Up.'],                       'price' => 15000, 'category' => $drinks],
            ['slug' => 'coca-cola-can',       'name' => ['en' => 'Coca-Cola Can',          'el' => 'Κουτί Coca-Cola'],           'desc' => ['en' => 'Chilled Coca-Cola can.', 'el' => 'Κρύο κουτί Coca-Cola.'],           'price' => 15000, 'category' => $drinks],
        ];

        foreach ($regularProducts as $data) {
            $product = Product::firstOrCreate(
                ['slug' => $data['slug']],
                [
                    'category_id' => optional($data['category'])->id ?? Category::query()->first()->id,
                    'name' => $data['name'],
                    'description' => $data['desc'],
                    'price' => $data['price'],
                    'is_combo' => false,
                ]
            );

            if ($hasImage && $product->wasRecentlyCreated && $product->getMedia('thumbnail')->isEmpty()) {
                $product->addMedia($demoImage)->preservingOriginal()->toMediaCollection('thumbnail');
            }
        }

        // --- Variants for Crispy Chicken Rice (Size M / Size L) ---
        $chickenRice = Product::query()->where('slug', 'crispy-chicken-rice')->first();

        if ($chickenRice && $chickenRice->variants()->doesntExist()) {
            ProductVariant::insert([
                [
                    'product_id' => $chickenRice->id,
                    'name' => json_encode(['en' => 'Size M', 'el' => 'Μέγεθος M']),
                    'price_adjustment' => 0,
                    'sort_order' => 1,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'product_id' => $chickenRice->id,
                    'name' => json_encode(['en' => 'Size L', 'el' => 'Μέγεθος L']),
                    'price_adjustment' => 10000,
                    'sort_order' => 2,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        // --- Combo product ---
        $setGa = Product::firstOrCreate(
            ['slug' => 'special-chicken-set'],
            [
                'category_id' => optional($comboCategory)->id ?? Category::query()->first()->id,
                'name' => ['en' => 'Special Chicken Set', 'el' => 'Σετ Κοτόπουλο Ειδικό'],
                'description' => ['en' => 'Chicken combo with drink and size choice.', 'el' => 'Κόμπο κοτόπουλο με ποτό και επιλογή μεγέθους.'],
                'price' => 80000,
                'is_combo' => true,
            ]
        );

        if ($hasImage && $setGa->wasRecentlyCreated && $setGa->getMedia('thumbnail')->isEmpty()) {
            $setGa->addMedia($demoImage)->preservingOriginal()->toMediaCollection('thumbnail');
        }

        if ($setGa->comboGroups()->doesntExist()) {
            $pepsi = Product::query()->where('slug', 'pepsi-can')->first();
            $upSeven = Product::query()->where('slug', '7up-can')->first();
            $sizeM = ProductVariant::query()->whereJsonContains('name->en', 'Size M', 'and', false)->first();
            $sizeL = ProductVariant::query()->whereJsonContains('name->en', 'Size L', 'and', false)->first();

            $drinkGroup = ComboGroup::create([
                'product_id' => $setGa->id,
                'name' => ['en' => 'Choose Drink', 'el' => 'Επιλέξτε Ποτό'],
                'min_select' => 1,
                'max_select' => 1,
                'is_required' => true,
            ]);

            ComboGroupItem::insert([
                ['combo_group_id' => $drinkGroup->id, 'product_id' => $pepsi->id,   'product_variant_id' => null, 'extra_price' => 0,    'created_at' => now(), 'updated_at' => now()],
                ['combo_group_id' => $drinkGroup->id, 'product_id' => $upSeven->id, 'product_variant_id' => null, 'extra_price' => 5000, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $sizeGroup = ComboGroup::create([
                'product_id' => $setGa->id,
                'name' => ['en' => 'Choose Size', 'el' => 'Επιλέξτε Μέγεθος'],
                'min_select' => 1,
                'max_select' => 1,
                'is_required' => true,
            ]);

            ComboGroupItem::insert([
                ['combo_group_id' => $sizeGroup->id, 'product_id' => null, 'product_variant_id' => $sizeM?->id, 'extra_price' => 0,     'created_at' => now(), 'updated_at' => now()],
                ['combo_group_id' => $sizeGroup->id, 'product_id' => null, 'product_variant_id' => $sizeL?->id, 'extra_price' => 10000, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }
}
