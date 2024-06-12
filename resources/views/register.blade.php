@extends('platform::dashboard')
<!-- Option 1: Include in HTML -->

@section('title','Registro de ingresos')

@section('description', '')

@section('navbar')
<!-- <nav aria-label="breadcrumb">
    <ol class="breadcrumb px-4 mb-2">
        <li class="breadcrumb-item">
            <a href="/admin/main">Inicio</a>
        </li>
        <li class="breadcrumb-item active">Ingresos</li>
    </ol>
</nav> -->
@stop

@section('content')
<div class="h-100">
    <div class="row g-3">
        <div class="col-md col-md-4 order-md-first">
            <form action="{{ route('income') }}" method="POST">
                <fieldset class="mb-3" data-async="">
                    <div class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column">
                        <div class="form-group">
                            <label for="field-identification-f427fc79053c64c6692c17076e9052a01793d5f2" class="form-label">Identificación
                                <sup class="text-danger">*</sup>
                            </label>
                            <div data-controller="input" data-input-mask="">
                                <input class="form-control" name="identification" title="Identificación" type="text" max="50" required="required" id="identification" autofocus>
                                <small class="form-text text-muted">Presione <strong>enter</strong> para realizar el ingreso del cliente, al escanear su tarjeta esto se hará automaticamente</small>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="col-md col-md-8 order-md-last order-first">
            <div class="rounded bg-white mb-3 p-3">
                <!-- <div class="border-dashed d-flex align-items-center w-100 rounded overflow-hidden" style="min-height: 250px;">
                    <h2 class="text-muted center fw-light">Dummy <small class="d-block text-center">kn6MtZpS</small></h2>
                </div> -->
                <table class="table table-compact table-striped">
                    <thead>
                        <th>Cliente</th>
                        <th>¿Ingresó?</th>
                        <th>Registro</th>
                    </thead>
                    <tbody>
                        @foreach ($registers as $item)
                        <tr>
                            <td>
                                <a class="btn btn-link" href="{{route('platform.clients.view', $item->client->id )}}">{{ $item->client->firstname }} {{ $item->client->lastname }}</a>
                            </td>
                            <td>
                                @if($item->income)
                                <span class="badge rounded-pill bg-success">Admitido</span>
                                @else
                                <span class="badge rounded-pill bg-warning">No admitido</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('d/m/Y h:i a') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

</script>

@stop