<?php

namespace App\Orchid\Screens\Client;

use App\Models\Client;
use App\Models\Payment;
use App\Orchid\Layouts\Client\ClientListLayout;
use App\Orchid\Layouts\Payment\PaymentRegisterLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ClientListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'clients' => Client::filters()->defaultSort('id', 'desc')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Clientes';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Crear'))
                ->icon('bs.plus-circle')
                ->href(route('platform.clients.create')),
        ];
    }

    public function layout(): iterable
    {
        return [
            ClientListLayout::class,
            Layout::modal('Registrar pago', PaymentRegisterLayout::class),
        ];
    }

    public function remove($id): void
    {
        Toast::info($id);
    }

    public function savePayemt(Request $request,  $id): void
    {
        $payment = new Payment();
        $payment->fill([
            'client_id' => $id,
            'amount' => $request->get('amount')
        ]);
        $payment->save();
        Toast::success('Pago registrado con exito.');
    }
}
