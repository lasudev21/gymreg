<?php

namespace App\Orchid\Screens\Client;

use App\Models\Client;
use App\Models\Payment;
use App\Orchid\Layouts\Payment\PaymentListLayout;
use App\Orchid\Layouts\Payment\PaymentRegisterLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ClientViewScreen extends Screen
{

    public $client;

    public function query(Client $client): iterable
    {
        $payments = Payment::where('client_id', $client->id)->filters()->defaultSort('id', 'desc')->paginate(10);

        return [
            'client' => $client,
            'payments' => $payments
        ];
    }

    public function name(): ?string
    {
        return 'Detalles del cliente';
    }

    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Registrar pago')
                ->modal('Registrar pago')
                ->method('savePayemt')
                ->icon('currency-dollar'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::modal('Registrar pago', PaymentRegisterLayout::class)
                ->applyButton('Registrar Pago')
                ->closeButton('Cancelar'),
            Layout::split([
                Layout::legend('client', [
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
                ]),
                PaymentListLayout::class,
            ])->ratio('60/40')->reverseOnPhone(),

        ];
    }

    public function savePayemt(Request $request, Client $client): void
    {
        $payment = new Payment;
        $payment->fill([
            'client_id' => $client->id,
            'amount' => $request->get('amount')
        ]);
        $payment->save();
        Toast::success('Pago registrado con exito.');
    }
}
