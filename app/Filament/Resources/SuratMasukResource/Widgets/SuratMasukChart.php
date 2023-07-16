<?php

namespace App\Filament\Resources\SuratMasukResource\Widgets;

use Filament\Widgets\BarChartWidget;

class SuratMasukChart extends BarChartWidget
{
    protected function getHeading(): string
    {
        return 'Blog posts';
    }
 
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                    'backgroundColor' => ['#0369a1']
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
