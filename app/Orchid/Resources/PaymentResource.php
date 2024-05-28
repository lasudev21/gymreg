<?php

namespace App\Orchid\Resources;

use App\Models\Payment;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\TD;

class PaymentResource extends Resource
{

    public static $model = Payment::class;

    public static function perPage(): int
    {
        return 50;
    }

    public static function displayInNavigation(): bool
    {
        return false;
    }

    public function fields(): array
    {
        return [
            Input::make('amount')
                ->title('Monto')
                ->type('number')
                ->required(),

            Input::make('client_id')
                ->title('Cliente')
                // ->type('number')
                ->required(),
        ];
    }

    public function columns(): array
    {
        return [
            // TD::make('id'),

            TD::make('client_id', 'Cliente')
                ->render(function ($model) {
                    return $model->client->firstname . ' ' . $model->client->lastname;
                }),

            TD::make('amount', 'Monto'),

            TD::make('created_at', 'Date of pago')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

            // TD::make('updated_at', 'Update date')
            //     ->render(function ($model) {
            //         return $model->updated_at->toDateTimeString();
            //     }),
        ];
    }

    public function legend(): array
    {
        return [];
    }

    public function filters(): array
    {
        return [];
    }

    public function with(): array
    {
        return ['client'];
    }
}
