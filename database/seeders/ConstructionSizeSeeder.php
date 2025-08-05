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
                ['length' => 200, 'width' => 150, 'height' => 100],
                ['length' => 210, 'width' => 160, 'height' => 110],
                ['length' => 250, 'width' => 200, 'height' => 150],
            ],
            'fefco_0426' => [
                ['length' => 300, 'width' => 300, 'height' => 40],
                ['length' => 320, 'width' => 320, 'height' => 45],
                ['length' => 350, 'width' => 350, 'height' => 50],
            ],
            'fefco_0201' => [
                ['length' => 400, 'width' => 300, 'height' => 250],
                ['length' => 420, 'width' => 320, 'height' => 270],
                ['length' => 450, 'width' => 350, 'height' => 300],
            ],
            'fefco_0300' => [
                ['length' => 150, 'width' => 150, 'height' => 50],
                ['length' => 160, 'width' => 160, 'height' => 60],
                ['length' => 180, 'width' => 180, 'height' => 70],
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
                    ]);
                }
            }
        }
    }
}
