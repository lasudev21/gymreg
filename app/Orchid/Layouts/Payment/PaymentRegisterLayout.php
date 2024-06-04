<?php

namespace App\Orchid\Layouts\Payment;

use Carbon\Carbon;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class PaymentRegisterLayout extends Rows
{
    protected function fields(): iterable
    {
        return [
            Group::make([
                Input::make('amount')
                    ->title('Monto')
                    ->type('number')
                    ->value(50000)
                    ->required(),
                Input::make('term')
                    ->title('Periodo')
                    ->type('month')
                    ->value(Carbon::now()->format('Y-m'))
                    ->required(),
            ]),
        ];
    }
}
