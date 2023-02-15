@extends('administration.common.card-form')

@section('form')
    <form   method="POST"
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
                    value="{{ $userCompanyInstitution->name ?? '' }}"
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
                    value="{{ $userCompanyInstitution->last_name ?? '' }}"
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
            <label for="company_institution_id">Empresa / Instituci&oacute;n</label>
            <select     name="company_institution_id"
                        id="company_institution_id"
                        class="form-control {{ $errors->has('company_institution_id') ? 'is-invalid' : '' }}"
            >
                <option value="">Seleccione</option>
                @foreach($companiesInstitutions as $companyInstitution)
                    @if(!empty($userCompanyInstitution))
                        @if($companyInstitution->id == $userCompanyInstitution->companyInstitution->id)
                            <option value="{{ $companyInstitution->id }}" selected>{{ $companyInstitution->name }}</option>
                        @else
                            <option value="{{ $companyInstitution->id }}">{{ $companyInstitution->name }}</option>
                        @endif
                    @else
                        <option value="{{ $companyInstitution->id }}">{{ $companyInstitution->name }}</option>
                    @endif
                @endforeach
            </select>
            @error('company_institution_id')
            <div class="invalid-feedback">
                Seleccione una Empresa / Instituci&oacute;n
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="name">E-mail</label>
            <input  type="text"
                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    name="email"
                    id="email"
                    value="{{ $userCompanyInstitution->email ?? '' }}"
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
        @if(empty($method))
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
        @else
            <div class="form-group">
                <div class="form-check">
                    <input  class="form-check-input"
                            type="checkbox"
                            value="1"
                            name="swEnablePassword"
                            id="swEnablePassword"
                    >
                    <label class="form-check-label" for="swEnablePassword">
                        Cambiar contraseña del usuario?
                    </label>
                </div>
            </div>
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
                        disabled
                >
                @error('password')
                <div class="invalid-feedback">
                    Ingrese una Contraseña V&aacute;lida
                </div>
                @enderror
            </div>
        @endif
        <button type="submit" class="btn btn-primary">
            {{ $button }}
        </button>
    </form>
@endsection

@section('js')
    @parent
    <script src="{{ asset('js/administration/users-company-institution_create.js') }}">
    </script>
@endsection


