@extends('page.common.card-form')

@section('form')
    <form   enctype="multipart/form-data"
            method="POST"
            action="{{ $action }}"
            novalidate
    >
        @csrf
        @if(!empty($method))
            @method($method)
        @endif
        <div class="form-group">
            <label for="name">Nombre(s)</label>
            <input  type="text"
                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                    name="name"
                    id="name"
                    value="{{ $user->name ?? '' }}"
                    autocomplete="off"
                    placeholder="Nombre(s)"
                    aria-describedby="name"
            >
            @error('name')
            <div class="invalid-feedback">
                Ingrese un Nombre V&aacute;lido
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name">Apellido(s)</label>
            <input  type="text"
                    class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                    name="last_name"
                    id="last_name"
                    value="{{ $user->last_name ?? '' }}"
                    autocomplete="off"
                    placeholder="Apellido(s)"
                    aria-describedby="last_name"
            >
            @error('last_name')
            <div class="invalid-feedback">
                Ingrese Apellido(s) V&aacute;lido(s)
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name">E-mail</label>
            <input  type="text"
                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    name="email"
                    id="email"
                    value="{{ $user->email ?? '' }}"
                    autocomplete="off"
                    placeholder="E-mail"
                    aria-describedby="email"
            >
            @error('email')
            <div class="invalid-feedback">
                Ingrese un E-mail V&aacute;lido
            </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
@endsection
