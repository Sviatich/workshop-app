<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Construction;
use App\Models\ConstructionSize;

class ConstructionSizeSeeder extends Seeder
{
    public function run(): void
    {
        $sizesData = [
            'fefco_0427' => [
                ['length' => 200, 'width' => 150, 'height' => 100, 'stock' => true],
                ['length' => 210, 'width' => 160, 'height' => 110, 'stock' => true],
                ['length' => 250, 'width' => 200, 'height' => 150, 'stock' => false],
            ],
            'fefco_0426' => [
                ['length' => 300, 'width' => 300, 'height' => 40,  'stock' => true],
                ['length' => 320, 'width' => 320, 'height' => 45,  'stock' => true],
                ['length' => 350, 'width' => 350, 'height' => 50,  'stock' => false],
            ],
            'fefco_0201' => [
                ['length' => 400, 'width' => 300, 'height' => 250, 'stock' => true],
                ['length' => 420, 'width' => 320, 'height' => 270, 'stock' => true],
                ['length' => 450, 'width' => 350, 'height' => 300, 'stock' => false],
            ],
            'fefco_0300' => [
                ['length' => 150, 'width' => 150, 'height' => 50,  'stock' => true],
                ['length' => 160, 'width' => 160, 'height' => 60,  'stock' => true],
                ['length' => 180, 'width' => 180, 'height' => 70,  'stock' => false],
            ],
        ];

        foreach ($sizesData as $constructionCode => $sizes) {
            $construction = Construction::where('code', $constructionCode)->first();
            if ($construction) {
                foreach ($sizes as $size) {
                    ConstructionSize::create([
                        'construction_id' => $construction->id,
                        'length'          => $size['length'],
                        'width'           => $size['width'],
                        'height'          => $size['height'],
                        'stock'           => $size['stock'],
                    ]);
                }
            }
        }
    }
}
