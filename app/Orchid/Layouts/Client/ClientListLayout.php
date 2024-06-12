<?php

namespace App\Orchid\Layouts\Client;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Components\Cells\Boolean;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ClientListLayout extends Table
{
    protected $target = 'clients';

    protected function striped(): bool
    {
        return true;
    }

    protected function compact(): bool
    {
        return true;
    }

    public function columns(): array
    {
        return [
            TD::make('firstname', 'Nombres')
                ->filter(Input::make())
                ->sort(),

            TD::make('lastname', 'Apellidos')
                ->filter(Input::make())
                ->sort(),

            TD::make('identification', 'N° identidad')
                ->filter(Input::make())
                ->sort()->width(150),

            TD::make('status', 'Estado')
                ->usingComponent(Boolean::class, true: 'Activo', false: 'Inactivo'),

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

            // TD::make('income', '¿Ingresó?')
            //     ->render(function ($model) {
            //         $ingreso = "";
            //         if ($model->income)
            //             $ingreso = '<span class="badge rounded-pill bg-success">Admitido</span>';
            //         else
            //             $ingreso = '<span class="badge rounded-pill bg-warning">No admitido</span>';
            //         return $ingreso;
            //     }),

            TD::make('dateadmission', 'Miembro desde')
                ->render(function ($model) {
                    return $model->created_at->toDateString();
                }),

            TD::make(__('Acciones'))
                ->align(TD::ALIGN_CENTER)
                ->width('10px')
                ->render(fn ($client) => Group::make([
                    DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            ModalToggle::make('Registrar pago')
                                ->modal('Registrar pago')
                                ->method('savePayemt',  [
                                    'id' => $client->id,
                                ])
                                ->icon('currency-dollar')
                                ->applyButton('Registrar Pago')
                                ->closeButton('Cancelar'),
                            Link::make(__('Ver'))
                                ->route('platform.clients.view', $client)
                                ->icon('bs.eye'),
                            Link::make(__('Editar'))
                                ->route('platform.clients.edit', $client)
                                ->icon('bs.pencil'),
                            Button::make($client->status ? __('Inactivar') : __('Activar'))
                                ->icon($client->status ? 'bs.trash3' : 'check-circle')
                                ->confirm(__('Está seguro que desea ' . ($client->status ? 'Inactivar' : 'Activar') . ' este cliente?'))
                                ->method('remove', [
                                    'id' => $client->id,
                                    'status' => !$client->status,
                                ]),
                        ])
                ])),
        ];
    }
}
