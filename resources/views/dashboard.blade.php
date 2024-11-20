@extends('adminlte::page')

@section('title', 'Control Cartera')

@section('content_header')
    <h1>Sistema Control Cartera</h1>
@stop

@section('content')
    <div class="container-fluid px-4">
        <div class="row mb-3">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Total de Pólizas Subidas</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pólizas con Pagos</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Total de Pagos</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pólizas Pendientes</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Gráfico de Pólizas Subidas por Mes</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="polizasMes" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Gráfico de Pagos Realizados</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="pagosRealizados" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/chart.js@3.9.0/dist/chart.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.0/dist/chart.min.js"></script>
    
@stop
