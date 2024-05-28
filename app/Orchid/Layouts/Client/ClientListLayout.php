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

    public function columns(): array
    {
        return [
            TD::make('firstname', 'Nombres')
                ->filter(Input::make())
                ->sort(),

            TD::make('lastname', 'Apellidos')
                ->filter(Input::make())
                ->sort(),

            TD::make('identification', 'Número de identidad')
                ->filter(Input::make())
                ->sort(),

            TD::make('status', 'Estado')
                ->usingComponent(Boolean::class, true: 'Activo', false: 'Inactivo')
            // ->render(function ($model) {
            //     if ($model->status)
            //         return 'Activo';
            //     else
            //         return 'Inactivo';
            // })
            ,

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

            TD::make(__('Actions'))
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
                                ->route('platform.clients.view', $client->id)
                                ->icon('bs.eye'),
                            Link::make(__('Editar'))
                                ->route('platform.clients.edit', $client->id)
                                ->icon('bs.pencil'),
                            Button::make(__('Eliminar'))
                                ->icon('bs.trash3')
                                ->confirm(__('Está seguro que desea eliminar este usuario?'))
                                ->method('remove', [
                                    'id' => $client->id,
                                ]),
                        ])
                ])),
        ];
    }
}
