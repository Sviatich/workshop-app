<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\SizeMatcher;

class TestSizeMatcher extends Command
{
    /**
     * Сигнатура команды
     */
    protected $signature = 'test:sizematcher 
        {construction : Код конструкции (например, fefco_0427)} 
        {length : Длина в мм} 
        {width : Ширина в мм} 
        {height : Высота в мм}';

    /**
     * Описание команды
     */
    protected $description = 'Тестирование поиска ближайших размеров и проверки совпадений';

    public function handle()
    {
        $construction = $this->argument('construction');
        $length = (int)$this->argument('length');
        $width = (int)$this->argument('width');
        $height = (int)$this->argument('height');

        $this->info("=== Проверка SizeMatcher ===");

        $exact = SizeMatcher::isExactMatch($construction, $length, $width, $height);
        $this->line("Точное совпадение: " . ($exact ? "ДА" : "НЕТ"));

        $nearest = SizeMatcher::findNearest($construction, $length, $width, $height, 5);

        if (empty($nearest)) {
            $this->warn("Ближайшие размеры не найдены");
        } else {
            $this->info("Ближайшие размеры:");
            foreach ($nearest as $size) {
                $this->line("- {$size['length']} × {$size['width']} × {$size['height']} мм | В наличии: " . ($size['stock'] ? "Да" : "Нет"));
            }
        }

        return Command::SUCCESS;
    }
}
