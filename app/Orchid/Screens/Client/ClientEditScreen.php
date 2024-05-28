<?php

namespace App\Orchid\Screens\Client;

use App\Models\Client;
use App\Orchid\Layouts\Client\ClientEditLayout;
use App\Orchid\Layouts\Payment\PaymentRegisterLayout;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;

class ClientEditScreen extends Screen
{

    public $client;

    public function query(Client $client): iterable
    {
        return [
            'client'       => $client,
        ];
    }

    public function name(): ?string
    {
        return $this->client->exists ? 'Editar Cliente' : 'Crear Cliente';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Guardar'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            ClientEditLayout::class,
        ];
    }

    public function save(Request $request, Client $client)
    {
        $client->fill($request->get('client'));
        $client->save();

        Toast::success("Cliente creado con éxito");

        return redirect()->route('platform.clients');
    }

    public function remove(Client $client)
    {
        $client->delete();

        Toast::info('Cliente eliminado');

        return redirect()->route('platform.clients');
    }
}
