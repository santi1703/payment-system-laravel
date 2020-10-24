@extends('templates.base')

@section('content')
    <h3>Usuarios</h3>
    <div class="border p-4 rounded mb-3">
        <form action="{{ route('locate-user') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="first_name" class="col-form-label">Nombre</label>
                <input type="text" name="first_name" value="{{ $firstName }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="last_name" class="col-form-label">Apellido</label>
                <input type="text" name="last_name" value="{{ $lastName }}" class="form-control">
            </div>
            <input type="submit" value="Consultar" class="btn btn-primary"/>
            <a href="{{ route('locate-user') }}" class="btn btn-secondary"> Limpiar</a>
        </form>
    </div>
    <div>
        @forelse($users as $user)
            <div class="border p-4 mb-2 rounded bg-light">
                <h4>Usuario: {{ $user->fullName }}</h4>
                <div>Última provincia: {{ $user->getLastKnownProvince() }}</div>
            </div>
        @empty
            <div class="border p-4 mb-2 rounded bg-info">
                No se encontraron usuarios con los datos indicados.
            </div>
        @endforelse
    </div>
@endsection
