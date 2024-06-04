<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Orchid\Support\Facades\Toast;

use function Pest\Laravel\json;

class RegisterController extends Controller
{
    public function index()
    {
        $registers = Register::with('client')->take(10)->orderBy('id', 'desc')->get();
        return view('register', compact('registers'));
    }

    public function income(Request $request)
    {
        // error_log($request->input('identification'));
        $client = Client::with('payments')->where('identification', '=', $request->input('identification'))->first();

        error_log($client);
        if ($client) {
            $reg = new Register();
            $reg->income = $client->status ? true : false;
            $reg->client_id = $client->id;
            $reg->save();
            if ($client->status)
                Toast::success("Registro de ingreso creado");
            else
                Toast::warning("El cliente no se encuentra activo");
        } else {
            Toast::error("Cliente no encontrado");
        }

        return Redirect::back()->with('message', 'Operation Successful !');
    }
}
