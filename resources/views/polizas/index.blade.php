@extends('adminlte::page')

@section('title', 'Lista de Pólizas')

@section('content_header')
    <h1>Lista de Pólizas</h1>
@stop

<!-- Mensaje de éxito o error -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
            <table id="listaPolizas" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th class= "table-header">Id</th>
                        <th class= "table-header">Cliente</th>
                        <th class= "table-header">Número de Póliza</th>
                        <th class= "table-header">Compañía</th>
                        <th class= "table-header">Forma de Pago</th>
                        <th class= "table-header">Total a Pagar</th>
                        <th class= "table-header">Archivo</th>
                        <th class= "table-header">Fecha de Inicio</th>
                        <th class= "table-header">Fecha de Fin</th>
                        <th class= "table-header">Pagos Subsecuentes</th>
                        <th class= "table-header">Fecha de Creación</th>
                        <th class= "table-header">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                  
                </tbody>
            </table>
        </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
        .table-header{
            white-space: nowrap; /* Evita que el texto se divida en varias líneas */
            overflow: hidden;   /* Oculta el texto que sobrepase el ancho */
            text-overflow: ellipsis; /* Añade "..." al final del texto truncado */
            max-width: 150px;   /* Ajusta el ancho máximo según tus necesidades */
 
        }
    </style>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script>
        $(document).ready(function() {
            $('#listaPolizas').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-MX.json',
                },
            });
        });
    </script>
@stop
