<?php

namespace App\Orchid\Layouts\Register;

use Orchid\Screen\Components\Cells\DateTime;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class RegisterListLayout extends Table
{
    protected $target = 'registers';

    protected function striped(): bool
    {
        return true;
    }

    protected function compact(): bool
    {
        return true;
    }

    protected function columns(): iterable
    {
        return [
            TD::make('created_at', 'Fecha de ingreso')
                // ->filter(DateTime::class)
                ->render(function ($model) {
                    return $model->created_at->toDateString();
                })
                ->sort(),

            TD::make('income', '¿Ingresó?')
                ->render(function ($model) {
                    $ingreso = "";
                    if ($model->income)
                        $ingreso = '<span class="badge rounded-pill bg-success">Admitido</span>';
                    else
                        $ingreso = '<span class="badge rounded-pill bg-warning">No admitido</span>';
                    return $ingreso;
                }),
        ];
    }
}
