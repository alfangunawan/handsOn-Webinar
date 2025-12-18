<?php

namespace Modules\Katering\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Katering\Entities\Katering;
use Modules\Katering\Entities\Menu;

class KateringDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo katering (only if not exists)
        $katering = Katering::firstOrCreate(
            ['name' => 'Dapur Nusantara'],
            ['description' => 'Katering dengan menu tradisional Indonesia']
        );

        // Create demo menus (only if not exists)
        $menus = [
            [
                'name' => 'Nasi Ayam Geprek',
                'description' => 'Nasi putih dengan ayam geprek sambal pedas, lalapan segar, dan kerupuk renyah.',
                'price' => 25000,
            ],
            [
                'name' => 'Rendang Padang',
                'description' => 'Rendang daging sapi empuk dengan bumbu rempah khas Padang yang nikmat.',
                'price' => 35000,
            ],
            [
                'name' => 'Salad Bowl Premium',
                'description' => 'Sayuran segar dengan protein pilihan dan dressing homemade yang lezat.',
                'price' => 30000,
            ],
            [
                'name' => 'Grilled Chicken Set',
                'description' => 'Ayam panggang dengan bumbu BBQ special, nasi butter, dan sayuran grill.',
                'price' => 40000,
            ],
            [
                'name' => 'Mie Goreng Special',
                'description' => 'Mie goreng dengan topping telur, bakso, dan sayuran pilihan.',
                'price' => 22000,
            ],
            [
                'name' => 'Bento Salmon Teriyaki',
                'description' => 'Set bento dengan salmon teriyaki, nasi jepang, dan side dish lengkap.',
                'price' => 55000,
            ],
        ];

        foreach ($menus as $menuData) {
            Menu::firstOrCreate(
                [
                    'katering_id' => $katering->id,
                    'name' => $menuData['name'],
                ],
                [
                    'description' => $menuData['description'],
                    'price' => $menuData['price'],
                ]
            );
        }
    }
}

