<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\InvalidRegisterMail;
use App\Models\Client;
use App\Models\Register;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Orchid\Support\Facades\Toast;

class RegisterController extends Controller
{
    public function index()
    {
        $registers = Register::with('client')->take(12)->orderBy('id', 'desc')->get();
        return view('register', compact('registers'));
    }

    public function income(Request $request)
    {
        // error_log($request->input('identification'));
        $client = Client::with('payments')->where('identification', '=', $request->input('identification'))->first();
        // error_log($client);

        if ($client) {
            $ingreso = $this->ValidateIncome($client);
            // error_log('' . $ingreso);

            $reg = new Register();
            $reg->income = $client->status ? $ingreso->status : false;
            $reg->client_id = $client->id;
            $reg->save();

            if ($client->status) {
                if (!$ingreso->status && env('APP_SENDMAIL')) {
                    $this->EnviarMail($client);
                }
                Toast::success($ingreso->message);
            } else
                Toast::warning("El cliente no se encuentra activo");
        } else {
            Toast::error("Cliente no encontrado");
        }

        return Redirect::back()->with('message', 'Operation Successful !');
    }

    private function ValidateIncome($client)
    {
        $response = new \stdClass();
        $response->status = false;
        $response->message = '';

        try {

            $fechaActual = Carbon::now();
            $diaIngreso = Carbon::parse($client->dateadmission);

            // error_log($fechaActual->day . ' - ' . $diaIngreso->day);

            $year = $fechaActual->month == 1 ? $fechaActual->subMonth(1)->year : $fechaActual->year;
            $month = $fechaActual->day <= $diaIngreso->day ? $fechaActual->subMonth()->month : $fechaActual->month;
            $term = $year . "-" . ($month <= 9 ? '0' . $month : $month);

            // error_log($term);

            $payment = $client->payments()->where('term', $term)->get();
            // error_log($payment);

            if ($payment->count() > 0) {
                $response->status = true;
                $response->message = 'Cliente admitido';
            } else {
                $response->status = false;
                $response->message = 'El cliente presenta moras en su pagos';
            }

            // error_log($payment);
        } catch (\Throwable $th) {
            error_log($th);
            $response->status = false;
            $response->message = 'Error no controlado, por favor contacte a soporte';
        }

        return $response;
    }

    private function EnviarMail($client)
    {
        if ($client->email != "") {
            Mail::to($client->email)->send(new InvalidRegisterMail($client));
        }
    }
}
