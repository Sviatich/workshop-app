<?php

namespace App\Helpers;

use App\Models\ConstructionSize;

class SizeMatcher
{
    /**
     * Поиск ближайших размеров по допуску ±80 мм.
     *
     * @param string $constructionCode — код конструкции (например, fefco_0427)
     * @param int $length — длина в мм
     * @param int $width — ширина в мм
     * @param int $height — высота в мм
     * @param int $limit — сколько ближайших вернуть
     * @return array
     */
    public static function findNearest(string $constructionCode, int $length, int $width, int $height, int $limit = 10): array
    {
        $sizes = ConstructionSize::query()
            ->whereHas('construction', function ($q) use ($constructionCode) {
                $q->where('code', $constructionCode);
            })
            ->whereBetween('length', [$length - 80, $length + 80])
            ->whereBetween('width', [$width - 80, $width + 80])
            ->whereBetween('height', [$height - 80, $height + 80])
            ->get();

        // Считаем эвклидово расстояние
        $sizes = $sizes->map(function ($size) use ($length, $width, $height) {
            $distance = sqrt(
                pow($size->length - $length, 2) +
                pow($size->width - $width, 2) +
                pow($size->height - $height, 2)
            );
            $size->distance = $distance;
            return $size;
        });

        // Сортируем по расстоянию
        $sizes = $sizes->sortBy('distance')->take($limit);

        // Приводим к массиву для ответа
        return $sizes->map(function ($size) {
            return [
                'length' => $size->length,
                'width' => $size->width,
                'height' => $size->height,
                'stock' => (bool) $size->stock,
            ];
        })->values()->toArray();
    }

    /**
     * Проверка, есть ли точное совпадение в базе
     */
    public static function isExactMatch(string $constructionCode, int $length, int $width, int $height): bool
    {
        return ConstructionSize::whereHas('construction', function ($q) use ($constructionCode) {
                $q->where('code', $constructionCode);
            })
            ->where('length', $length)
            ->where('width', $width)
            ->where('height', $height)
            ->exists();
    }
}
