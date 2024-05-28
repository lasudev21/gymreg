<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Client;

use App\Models\Client;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Sight;

class ClientViewLayout extends Rows
{

    protected function fields(): iterable
    {
        return [];
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
}
