@extends('administration.layout.dashboard')

@section('content')
    @include('administration.user-company-institution.section-title')
    <div class="card">
        <div class="card-body">
            @include('administration.user-company-institution.search-form')
            @if(Session::has('store'))
                <div class="alert alert-success" role="alert" style="margin-bottom: 1.2rem;">
                    <b>Usuario adicionado correctamente</b>
                </div>
            @endif
            @if(Session::has('update'))
                <div class="alert alert-primary" role="alert" style="margin-bottom: 1.2rem;">
                    <b>Datos de usuario actualizados correctamente</b>
                </div>
            @endif
            @if(Session::has('destroy'))
                <div class="alert alert-danger" role="alert" style="margin-bottom: 1.2rem;">
                    <b>Usuario eliminado correctamente</b>
                </div>
            @endif
            <hr>
            @if($usersCompanyInstitution->count() > 0)
                @foreach($usersCompanyInstitution as $userCompanyInstitution)
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <h5>Usuario</h5>
                            <p>{{ $userCompanyInstitution->name }} {{ $userCompanyInstitution->last_name }}</p>
                            <p>{{ $userCompanyInstitution->companyInstitution->name }}</p>
                            <span class="badge badge-info text-white">
                                <i class="fas fa-user"></i>
                                Cliente
                            </span>
                            <span class="badge badge-success">
                                <i class="fas fa-check"></i>
                                Activo
                            </span>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <h5 class="pt-3 pt-lg-0">E-mail</h5>
                            <p>{{ $userCompanyInstitution->email }}</p>
                        </div>
                        <div class="col-lg-4 pt-md-3 pt-lg-0">
                            <a  href="{{ route('administration.user-company-institution.edit', ['id' => $userCompanyInstitution->id]) }}"
                                class="btn btn-primary"
                            >
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form   method="POST"
                                    action="{{ route('administration.user-company-institution.destroy', ['id' => $userCompanyInstitution->id]) }}"
                                    style="display: inline"
                            >
                                @csrf
                                @method('DELETE')
                                <button     type="submit"
                                            class="btn btn-danger"
                                >
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                    <hr>
                @endforeach
                <br>
                {{ $usersCompanyInstitution->withQueryString()->links() }}
            @else
                <div class="alert alert-info" role="alert">
                    <b>A&uacute;n no se tienen usuarios registrados</b>
                </div>
            @endif
        </div>
    </div>
@endsection
