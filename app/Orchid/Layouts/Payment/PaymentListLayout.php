<?php

namespace App\Orchid\Layouts\Payment;

use Orchid\Screen\Components\Cells\Currency;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PaymentListLayout extends Table
{
    protected $target = 'payments';

    protected function striped(): bool
    {
        return true;
    }

    protected function columns(): iterable
    {
        return [
            TD::make('amount', 'Monto')
                ->usingComponent(Currency::class, decimals: 0, decimal_separator: ',', thousands_separator: '.', before: '$')
                ->sort(),
            TD::make('term', 'Periodo')
                // ->filter(Input::make())
                ->sort(),
        ];
    }
}
