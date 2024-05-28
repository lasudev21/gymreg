<?php

namespace App\Orchid\Resources;

use App\Models\Client;
use App\Orchid\Actions\ClientEditAction;
use Orchid\Crud\Resource;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;

class ClientResource extends Resource
{

    public static $model = Client::class;

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
            Input::make('firstname')
                ->title('Nombres')
                ->required(),

            Input::make('lastname')
                ->title('Apellido')
                ->required(),

            Select::make('identification_type')
                ->title('Tipo')
                ->options([
                    'CC'   => 'Cedula de cidadania',
                    'TI' => 'Tarjeta de identidad',
                    'NIT/RUT' => 'NIT/RUT',
                    'Pasaporte' => 'Pasaporte',
                ])
                ->required(),

            Input::make('identification')
                ->title('Numero de identificación')
                ->required(),

            DateTimer::make('birthdate')
                ->title('Fecha de nacimiento')
                ->format('Y-m-d')
                ->required(),

            Select::make('gender')
                ->title('Género')
                ->options([
                    'M'   => 'Masculino',
                    'F' => 'Femenino',
                    'O' => 'Otro',
                ])
                ->required(),

            Input::make('address')
                ->title('Dirección')
                ->required(),

            Input::make('phonenumber')
                ->title('Teléfono')
                ->required(),

            Input::make('email')
                ->title('Correo electronico')
                ->type('email'),

            DateTimer::make('dateadmission')
                ->title('Fecha de ingreso')
                ->format('Y-m-d')
                ->required(),
        ];
    }

    public function columns(): array
    {
        return [
            // TD::make('id'),

            TD::make('identification', 'Número de identidad')
                ->filter(Input::make())
                ->sort(),

            TD::make('firstname', 'Nombres')
                ->filter(Input::make())
                ->sort(),

            TD::make('lastname', 'Apellidos')
                ->filter(Input::make())
                ->sort(),

            TD::make('gender', 'Género')
                ->render(function ($model) {
                    $genero = "";
                    switch ($model->gender) {
                        case 'M':
                            $genero = "Másculino";
                            break;
                        case 'F':
                            $genero = "Femenino";
                            break;
                        default:
                            $genero = "Otro";
                            break;
                    }
                    return $genero;
                }),

            TD::make('created_at', 'Creado el')
                ->render(function ($model) {
                    return $model->created_at->toDateString();
                }),

            // TD::make('updated_at', 'Update date')
            //     ->render(function ($model) {
            //         return $model->updated_at->toDateTimeString();
            //     }),
        ];
    }

    public function legend(): array
    {
        return [
            Sight::make('firstname', 'Nombres'),
            Sight::make('lastname', 'Apellidos'),

            Sight::make('identification', 'Documento de identificación'),

            Sight::make('identification_type', 'Tipo')
                ->render(function ($model) {
                    $identificacion = "";
                    switch ($model->identification_type) {
                        case 'CC':
                            $identificacion = "Cédula de ciudadania";
                            break;
                        case 'TI':
                            $identificacion = "Tarjeta de identidad";
                            break;
                        default:
                            $identificacion = $model->identification_type;
                            break;
                    }
                    return $identificacion;
                }),
            Sight::make('birthdate', 'Fecha de nacimiento'),

            Sight::make('gender', 'Género')
                ->render(function ($model) {
                    $genero = "";
                    switch ($model->gender) {
                        case 'M':
                            $genero = "Másculino";
                            break;
                        case 'F':
                            $genero = "Femenino";
                            break;
                        default:
                            $genero = "Otro";
                            break;
                    }
                    return $genero;
                }),

            Sight::make('phonenumber', 'Teléfono'),
            Sight::make('address', 'Dirección'),
            Sight::make('email', 'Correo eléctronico'),
            Sight::make('dateadmission', 'Fecha de ingreso'),
        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function button(): Button
    {
        return Button::make('Registrar pago')->icon('coin');
    }

    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Launch demo modal')
                ->modal('exampleModal')
                ->method('action')
                ->icon('full-screen'),
        ];
    }
}
