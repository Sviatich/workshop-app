<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Calculators\Fefco0427Calculator;
use App\Calculators\Fefco0426Calculator;
use App\Calculators\Fefco0201Calculator;
use App\Calculators\Fefco0300Calculator;

class TestCalculator extends Command
{
    /**
     * Название и сигнатура команды
     */
    protected $signature = 'test:calc 
        {construction : Код конструкции (fefco_0427, fefco_0426, fefco_0201, fefco_0300)} 
        {length : Длина (мм)} 
        {width : Ширина (мм)} 
        {height : Высота (мм, можно 0)} 
        {color : Код цвета картона (brown, white_in, white)} 
        {tirage : Тираж}';

    /**
     * Описание команды
     */
    protected $description = 'Тестирование калькулятора коробок в консоли';

    public function handle()
    {
        $construction = $this->argument('construction');
        $length = (int)$this->argument('length');
        $width = (int)$this->argument('width');
        $height = (int)$this->argument('height');
        $color = $this->argument('color');
        $tirage = (int)$this->argument('tirage');

        $calculators = [
            'fefco_0427' => Fefco0427Calculator::class,
            'fefco_0426' => Fefco0426Calculator::class,
            'fefco_0201' => Fefco0201Calculator::class,
            'fefco_0300' => Fefco0300Calculator::class,
        ];

        if (!isset($calculators[$construction])) {
            $this->error("Неизвестная конструкция: $construction");
            return Command::FAILURE;
        }

        $calculator = new $calculators[$construction]();

        $result = $calculator->calculate([
            'length' => $length,
            'width' => $width,
            'height' => $height,
            'color' => $color,
            'tirage' => $tirage,
        ]);

        $this->info('Результат расчёта:');
        $this->line(print_r($result, true));

        return Command::SUCCESS;
    }
}
