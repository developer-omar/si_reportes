@extends('page.layout.app')

@section('content')
    <div class="container">
        <div class="row pb-3">
            <div class="col-12 d-flex flex-row justify-content-center">
                <h1 class="d-none d-md-block d-lg-block"
                    style="color: #262b40; text-transform: uppercase; font-size: 28px; font-weight: bold"
                >
                    Bienvenido a nuestro Sistema de Informes T&eacute;cnicos
                </h1>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                @foreach($companiesInstitutions as $companyInstitution)
                    <div class="col-12 col-md-4 col-lg-3">
                        <a  href="{{
                                route('auth.login.show-user-company-institution-login-form')
                        }}">
                            <img    src="{{ $companyInstitution->photo }}"
                                    alt="{{ $companyInstitution->name }}"
                                    style="height: 200px; width: 200px; margin: 2rem 0 1rem 0;"
                                    class="rounded mx-auto d-block"
                            >
                        </a>
                        <div class="text-center">
                            <a  href="
                            {{
                                route('auth.login.show-user-company-institution-login-form')
                            }}
                                " class="btn btn-outline-custom" >
                                <i class="fas fa-sign-in-alt"></i>
                                Ingrese al Sistema
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/page/index.css') }}">
@endsection
