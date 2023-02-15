@extends('page.common.card-form')

@section('form')
    @if(Session::has('error'))
        <div class="alert alert-danger" role="alert" style="margin-bottom: 1.2rem;">
            <b>La contraseña actual que ingres&oacute; no es la correcta</b>
        </div>
    @endif
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
            <label for="name">Contraseña</label>
            <input  type="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    name="password"
                    id="password"
                    value=""
                    autocomplete="off"
                    placeholder="Contraseña"
                    aria-describedby="password"
            >
            @error('password')
            <div class="invalid-feedback">
                Ingrese una Contraseña V&aacute;lida
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name">Nueva Contraseña</label>
            <input  type="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    name="new_password"
                    id="new_password"
                    value=""
                    autocomplete="off"
                    placeholder="Nueva Contraseña"
                    aria-describedby="password"
            >
            @error('password')
            <div class="invalid-feedback">
                Ingrese una nueva Contraseña V&aacute;lida
            </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">{{ $button }}</button>
    </form>
@endsection
