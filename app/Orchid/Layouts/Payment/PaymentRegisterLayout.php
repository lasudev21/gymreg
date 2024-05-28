<?php

namespace App\Orchid\Layouts\Payment;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class PaymentRegisterLayout extends Rows
{
    protected function fields(): iterable
    {
        return [
            Input::make('amount')
                ->title('Monto')
                ->type('number')
                ->required(),
        ];
    }
}
