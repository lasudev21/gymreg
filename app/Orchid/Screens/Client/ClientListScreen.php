<?php

namespace App\Orchid\Screens\Client;

use App\Models\Client;
use App\Models\Payment;
use App\Orchid\Layouts\Client\ClientListLayout;
use App\Orchid\Layouts\Payment\PaymentRegisterLayout;
use Exception;
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
            Layout::modal('Registrar pago', PaymentRegisterLayout::class)
                ->applyButton('Registrar pago')
                ->closeButton('Cancelar'),
        ];
    }

    public function remove($id): void
    {
        $client = Client::find($id);
        $client->status = false;
        $client->save();
        Toast::success('Cliente desactivado');
    }

    public function savePayemt(Request $request,  $id): void
    {
        try {
            $payment = new Payment;
            $payment->fill([
                'client_id' => $id,
                'amount' => $request->get('amount'),
                'term' => $request->get('term')
            ]);
            $payment->save();
            Toast::success('Pago registrado con exito.');
        } catch (Exception $e) {
            error_log($e->getMessage());
            if (strpos($e, 'SQLSTATE[23000]') !== false) {
                Toast::error('Ya existe un pago registrado del cliente para el periodo de tiempo seleccionado');
            } else {
                Toast::error('Error no controlado, por favor contacte a su administrador');
            }
        }
    }
}
