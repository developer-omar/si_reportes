@extends('page.layout.dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="d-none d-md-block col-md-4 col-lg-2">
                    <div class="d-flex justify-content-center">
                        <i  class="fas fa-user-circle"
                            style="font-size: 8rem; text-align: center"
                        >
                        </i>
                    </div>
                </div>
                <div class="col-12 col-md-8 col-lg-10">
                    <p>
                        <b>Usuario</b>
                    </p>
                    <p>
                        {{ $userCompanyInstitution->name }} {{ $userCompanyInstitution->last_name }}
                    </p>
                    <p>
                        <b>E-mail</b>
                    </p>
                    <p>
                        {{ $userCompanyInstitution->email }}
                    </p>
                    <a href="{{ route('page.user-company-institution-profile.edit') }}" class="btn btn-primary">
                        Editar Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
