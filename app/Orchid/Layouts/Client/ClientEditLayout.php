<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Client;

use App\Models\Client;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class ClientEditLayout extends Rows
{

    protected function fields(): iterable
    {
        return [
            Group::make([
                Input::make('client.firstname')
                    ->title('Nombres')
                    ->type('text')
                    ->max(50)
                    ->required(),

                Input::make('client.lastname')
                    ->title('Apellido')
                    ->required(),
            ]),

            Group::make([
                Select::make('client.identification_type')
                    ->title('Tipo')
                    ->options([
                        'CC'   => 'Cedula de cidadania',
                        'TI' => 'Tarjeta de identidad',
                        'NIT/RUT' => 'NIT/RUT',
                        'Pasaporte' => 'Pasaporte',
                    ])
                    ->required(),

                Input::make('client.identification')
                    ->title('Numero de identificación')
                    ->required(),
            ]),

            Group::make([
                Input::make('client.birthdate')
                    ->type('date')
                    ->title('Fecha de nacimiento')
                    ->format('Y-m-d')
                    ->required(),

                Select::make('client.gender')
                    ->title('Género')
                    ->options([
                        'M'   => 'Masculino',
                        'F' => 'Femenino',
                        'O' => 'Otro',
                    ])
                    ->required(),
            ]),

            Group::make([
                Input::make('client.address')
                    ->title('Dirección')
                    ->required(),

                Input::make('client.phonenumber')
                    ->title('Teléfono')
                    ->required(),
            ]),
            Group::make([
                Input::make('client.email')
                    ->title('Correo electronico')
                    ->type('email'),

                Input::make('client.dateadmission')
                    ->type('date')
                    ->title('Fecha de ingreso')
                    ->format('Y-m-d')
                    ->required(),
            ]),
        ];
    }
}
