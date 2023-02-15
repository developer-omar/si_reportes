@extends('administration.common.card-form')

@section('form')
    <div class="stepwizard col-md-offset-3">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step">
                <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                <p>Paso 1</p>
            </div>
            <div class="stepwizard-step">
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                <p>Paso 2</p>
            </div>
        </div>
    </div>

    <form   enctype="multipart/form-data"
            method="POST"
            action="{{ $action }}"
            novalidate
    >
        @csrf
        @if(!empty($method))
            @method($method)
        @endif
        <div class="row setup-content" id="step-1">
            <div class="col-12">
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
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary nextBtn" type="button">
                        Siguiente
                    </button>
                </div>
            </div>
        </div>
        <div class="row setup-content" id="step-2">
            <div class="col-12">

                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <input  class="form-check-input"
                                type="radio"
                                name="role"
                                id="userRole"
                                value="user"
                                @if($hasRoleUser)
                                checked
                                @endif
                        >
                        <label class="form-check-label" for="userRole">
                            Rol Usuario
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input  class="form-check-input"
                                type="radio"
                                name="role"
                                id="administratorRole"
                                value="administrator"
                                @if($hasRoleAdministrator)
                                checked
                                @endif
                        >
                        <label class="form-check-label" for="administratorRole">
                            Rol Administrador
                        </label>
                    </div>
                </div>

                {{--permissions for users or administrators--}}
                <div id="administratorUserPermissions">
                    <div class="alert alert-info" role="alert" style="margin-bottom: 1.2rem;">
                        <b>Seleccione los permisos para el usuario</b>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input  class="form-check-input"
                                    type="checkbox"
                                    value="1"
                                    name="reportPermissions"
                                    id="reportPermissions"
                                    @if($reportPermissions)
                                    checked
                                    @endif
                                    @if($hasRoleAdministrator)
                                    disabled
                                    @endif
                            >
                            <label class="form-check-label" for="reportPermissions">
                                Permisos de Informes
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input  class="form-check-input"
                                    type="checkbox"
                                    value="1"
                                    name="companyInstitutionPermissions"
                                    id="companyInstitutionPermissions"
                                    @if($companyInstitutionPermissions)
                                    checked
                                    @endif
                                    @if($hasRoleAdministrator)
                                    disabled
                                    @endif
                            >
                            <label class="form-check-label" for="companyInstitutionPermissions">
                                Permisos de Empresas / Instituciones
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input  class="form-check-input"
                                    type="checkbox"
                                    value="1"
                                    name="subsidiaryPermissions"
                                    id="subsidiaryPermissions"
                                    @if($subsidiaryPermissions)
                                    checked
                                    @endif
                                    @if($hasRoleAdministrator)
                                    disabled
                                    @endif
                            >
                            <label class="form-check-label" for="subsidiaryPermissions">
                                Permisos de Sucursales
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input  class="form-check-input"
                                    type="checkbox"
                                    value="1"
                                    name="userCompanyInstitutionPermissions"
                                    id="userCompanyInstitutionPermissions"
                                    @if($userCompanyInstitutionPermissions)
                                    checked
                                    @endif
                                    @if($hasRoleAdministrator)
                                    disabled
                                    @endif
                            >
                            <label class="form-check-label" for="userCompanyInstitutionPermissions">
                                Permisos de Usuarios Emp. / Inst.
                            </label>
                        </div>
                    </div>
                </div>

                <br>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary prevBtn" type="button">
                        Anterior
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{ $button }}
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    @parent
    <script src="{{ asset('js/administration/users-administration_create.js') }}">
    </script>
@endsection

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/administration/users-administration_create.css') }}">
@endsection
