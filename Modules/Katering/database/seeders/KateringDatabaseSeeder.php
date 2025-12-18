<?php

namespace Modules\Katering\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Katering\Entities\Katering;
use Modules\Katering\Entities\Menu;

class KateringDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo katering
        $katering = Katering::create([
            'name' => 'Dapur Nusantara',
            'description' => 'Katering dengan menu tradisional Indonesia'
        ]);

        // Create demo menus
        $menus = [
            [
                'katering_id' => $katering->id,
                'name' => 'Nasi Ayam Geprek',
                'description' => 'Nasi putih dengan ayam geprek sambal pedas, lalapan segar, dan kerupuk renyah.',
                'price' => 25000,
            ],
            [
                'katering_id' => $katering->id,
                'name' => 'Rendang Padang',
                'description' => 'Rendang daging sapi empuk dengan bumbu rempah khas Padang yang nikmat.',
                'price' => 35000,
            ],
            [
                'katering_id' => $katering->id,
                'name' => 'Salad Bowl Premium',
                'description' => 'Sayuran segar dengan protein pilihan dan dressing homemade yang lezat.',
                'price' => 30000,
            ],
            [
                'katering_id' => $katering->id,
                'name' => 'Grilled Chicken Set',
                'description' => 'Ayam panggang dengan bumbu BBQ special, nasi butter, dan sayuran grill.',
                'price' => 40000,
            ],
            [
                'katering_id' => $katering->id,
                'name' => 'Mie Goreng Special',
                'description' => 'Mie goreng dengan topping telur, bakso, dan sayuran pilihan.',
                'price' => 22000,
            ],
            [
                'katering_id' => $katering->id,
                'name' => 'Bento Salmon Teriyaki',
                'description' => 'Set bento dengan salmon teriyaki, nasi jepang, dan side dish lengkap.',
                'price' => 55000,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
