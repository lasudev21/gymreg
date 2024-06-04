<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Models\Client;
use App\Models\Register;
use App\Orchid\Layouts\Examples\ChartLineExample;
use App\Orchid\Layouts\Home\ChartLineRegisterDaily;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{

    public function query(): iterable
    {
        $values = [];
        $labels = [];
        $endDate = Carbon::now();
        $firstDay = $endDate->copy()->startOfMonth();
        $startDate = $endDate->copy()->subMonth();

        $registros = Register::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        if ($registros->isNotEmpty()) {
            foreach ($registros as $key => $value) {
                $values[] = $value->total;
                $labels[] = $value->date;
            }
        }

        error_log($firstDay->toString());

        $totalClientes = Client::where('status', '=', true)->count();
        $clientesMes = Client::whereBetween('created_at', [$firstDay, $endDate])->count();
        $registrosMes = Register::whereBetween('created_at', [$firstDay, $endDate])->count();

        return [
            'charts' => [
                [
                    'name'   => 'Ingresos en el último mes',
                    'values' => $values,
                    'labels' => $labels,
                ]
            ],
            'metrics' => [
                'visitors' => ['value' => number_format($clientesMes)],
                'orders'   => ['value' => number_format($registrosMes)],
                'sales'    => ['value' => number_format($totalClientes)],
            ],
        ];
    }

    public function name(): ?string
    {
        return 'Página principal';
    }

    public function description(): ?string
    {
        return 'Bienvenido de nuevo.';
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        return [
            Layout::metrics([
                'Clientes nuevos del mes' => 'metrics.visitors',
                'Ingresos en el mes' => 'metrics.orders',
                'Clientes activos'    => 'metrics.sales',
            ]),
            ChartLineRegisterDaily::make('charts', 'Ingresos diarios')
                ->description('Total de ingresos diarios agrupados por día a lo largo de un mes'),

            // Layout::view('platform::partials.update-assets'),
            // Layout::view('platform::partials.welcome'),
        ];
    }
}
