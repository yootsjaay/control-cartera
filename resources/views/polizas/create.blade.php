@extends('adminlte::page')
@section('title', 'Subir Poliza')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Subir Polizas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('companias.index') }}">Compañía</a></li>
        <li class="breadcrumb-item active">Registrar</li>
    </ol>

    <div class="card mb-4" style="max-width: 700px; margin: 0 auto;">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Subir Polizas
        </div>
        <div class="card-body">
            <div class="form-container">
                <form action="{{ route('companias.store') }}" method="POST">
                    @csrf
                    <!-- Campo para el nombre -->
                    <div class="form-group mb-3">
                        <label for="nombre">Nombre de la Compañía</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                        @if ($errors->has('nombre'))
                            <span class="text-danger">{{ $errors->first('nombre') }}</span>
                        @endif
                    </div>

                    <!-- Campo para seleccionar compañía relacionada -->
                    <div class="form-group mb-3">
                        <label for="compania_id">Compañía Relacionada</label>
                        <select name="compania_id" id="compania_id" class="form-select" required>
                            <option value="" disabled selected>Seleccione una compañía</option>
                            @foreach($companias as $compania)
                                <option value="{{ $compania->id }}" {{ old('compania_id') == $compania->id ? 'selected' : '' }}>
                                    {{ $compania->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('compania_id'))
                            <span class="text-danger">{{ $errors->first('compania_id') }}</span>
                        @endif
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary mt-3">Guardar Compañía</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
@stop

@section('js')
    <script>
        console.log('Página lista.');
    </script>
@stop
