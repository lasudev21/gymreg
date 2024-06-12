<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Models\Client;
use App\Models\Register;
use App\Orchid\Layouts\Home\ChartLineRegisterDaily;
use App\Orchid\Layouts\Home\ChartBarMonthClient;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{

    public function query(): iterable
    {
        $mesesARestar = 5;

        $endDate = Carbon::now();
        $firstDay = $endDate->copy()->startOfMonth();
        $startDate = $endDate->copy()->subMonth();
        $startMonth = $endDate->copy()->subMonth($mesesARestar);

        $registerDaily = $this->GetRegisterDaily($startDate, $endDate);
        $clientsMonth = $this->GetClientsMonth($startMonth, $endDate);

        return [
            'chartIngresosMes' => [$registerDaily],
            'chartClientes' => [$clientsMonth],
            'metrics' => $this->GetMetrics($firstDay, $endDate),
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
            ChartLineRegisterDaily::make('chartIngresosMes', 'Ingresos diarios')
                ->description('Total de ingresos diarios agrupados por día a lo largo de un mes'),

            Layout::columns([
                ChartBarMonthClient::make('chartClientes', 'Clientes nuevos por mes')
                    ->description('Total de clientes registrados durante el ùltimo año'),
            ]),
        ];
    }

    private function GetRegisterDaily($startDate, $endDate)
    {
        $values = [];
        $labels = [];
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

        return [
            'name'   => 'Ingresos en el último mes',
            'values' => $values,
            'labels' => $labels,
        ];
    }

    private function GetClientsMonth($startDate, $endDate)
    {
        $values = [];
        $labels = [];

        $registros = Client::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'), DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->get();

        if ($registros->isNotEmpty()) {
            foreach ($registros as $key => $value) {
                $values[] = $value->total;
                $labels[] = $value->date;
            }
        }

        return [
            'name'   => 'Clientes en el ultimo año',
            'values' => $values,
            'labels' => $labels,
        ];
    }

    private function GetMetrics($firstDay, $endDate)
    {
        $totalClientes = Client::where('status', '=', true)->count();
        $clientesMes = Client::whereBetween('created_at', [$firstDay, $endDate])->count();
        $registrosMes = Register::whereBetween('created_at', [$firstDay, $endDate])->count();
        return [
            'visitors' => ['value' => number_format($clientesMes)],
            'orders'   => ['value' => number_format($registrosMes)],
            'sales'    => ['value' => number_format($totalClientes)],
        ];
    }
}
