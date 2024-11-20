@extends('adminlte::page')

@section('title', 'Crear Póliza')

@section('content_header')
    <h1>Crear Nueva Póliza</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('polizas.store') }}">
                @csrf
                <!-- Campo para el nombre del asegurado -->
                <div class="mb-3">
                    <label for="nombre_asegurado" class="form-label">Nombre del Asegurado</label>
                    <input type="text" class="form-control" id="nombre_asegurado" name="nombre_asegurado" required>
                </div>
                
                <!-- Campo para la fecha de emisión -->
                <div class="mb-3">
                    <label for="fecha_emision" class="form-label">Fecha de Emisión</label>
                    <input type="date" class="form-control" id="fecha_emision" name="fecha_emision" required>
                </div>
                
                <!-- Campo para la fecha de vigencia -->
                <div class="mb-3">
                    <label for="fecha_vigencia" class="form-label">Fecha de Vigencia</label>
                    <input type="date" class="form-control" id="fecha_vigencia" name="fecha_vigencia" required>
                </div>

                <!-- Campo para los detalles de cobertura -->
                <div class="mb-3">
                    <label for="detalles_cobertura" class="form-label">Detalles de Cobertura</label>
                    <textarea class="form-control" id="detalles_cobertura" name="detalles_cobertura" rows="3" required></textarea>
                </div>

                <!-- Campo para las condiciones generales -->
                <div class="mb-3">
                    <label for="condiciones_generales" class="form-label">Condiciones Generales</label>
                    <textarea class="form-control" id="condiciones_generales" name="condiciones_generales" rows="3" required></textarea>
                </div>

                <!-- Botón de submit -->
                <button type="submit" class="btn btn-primary">Guardar Póliza</button>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
@stop
