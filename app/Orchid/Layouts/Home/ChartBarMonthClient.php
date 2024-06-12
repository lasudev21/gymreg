<?php

namespace App\Orchid\Layouts\Home;

use Orchid\Screen\Layouts\Chart;

class ChartBarMonthClient extends Chart
{
    protected $type = self::TYPE_BAR;
    protected $export = false;
}
