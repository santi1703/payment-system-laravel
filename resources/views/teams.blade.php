@extends('templates.base')

@section('content')
    <h3>Equipos</h3>
    @foreach($teams as $team)
        <div class="card mb-3">
            <div class="card-header bg-info">
                <h4>Nombre del equipo: {{ $team->niceName }}</h4>
            </div>
            <div class="card-header bg-light strong">
                Responsable: {{ $team->owner()->first()->fullName }}
            </div>
            @if(count($team->subscriptions))
                <div class="card-header bg-light strong">
                    Servicios:
                </div>
                <ul>
                    @foreach($team->subscriptions as $subscription)
                        <li>{{ $subscription->niceName }}</li>
                    @endforeach
                </ul>
                <div class="card-header bg-light strong">
                    Facturacion:
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($team->invoices as $invoice)
                        <li class="list-group-item">
                            <div class="row">
                                @if(!is_null($invoice->paid_on))
                                    <div class="col-md-3">Servicio: {{ $invoice->subscription }}</div>
                                    <div class="col-md-3">Monto: {{ $invoice->niceAmount }}</div>
                                    <div class="col-md-3">Estado: {{ $invoice->status }}</div>
                                    <div class="col-md-3">Pagado por: {{ $invoice->paid_by }}</div>
                                @else
                                    <div class="col-md-4">Servicio: {{ $invoice->subscription }}</div>
                                    <div class="col-md-4">Monto: {{ $invoice->niceAmount }}</div>
                                    <div class="col-md-4 bg-danger">Estado: {{ $invoice->status }}</div>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
            <div class="card-header bg-info strong">
                Miembros:
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    {{ $team->owner()->first()->fullName }} <span class="badge badge-primary">Responsable</span>
                </li>
                @foreach($team->members as $member)
                    <li class="list-group-item">{{ $member->fullName }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
@endsection
