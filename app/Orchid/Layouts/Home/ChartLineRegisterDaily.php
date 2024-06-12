<?php

namespace App\Orchid\Layouts\Home;

use Orchid\Screen\Layouts\Chart;

class ChartLineRegisterDaily extends Chart
{
    protected $type = 'line';

    protected $export = false;

    protected $height = 300;

    protected $lineOptions = [
        'spline'     => 1,
        'regionFill' => 1,
        'hideDots'   => 0,
        'hideLine'   => 0,
        'heatline'   => 0,
        'dotSize'    => 3,
    ];

    protected function markers(): ?array
    {
        return [
            [
                'label'   => 'Medium',
                'value'   => 40,
            ],
        ];
    }
}
