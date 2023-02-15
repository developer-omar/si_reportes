@extends('administration.layout.dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                @foreach($companiesInstitutions as $companyInstitution)
                    <div class="col-12 col-md-4 col-lg-3">
                        <a  href="{{
                                route('administration.company-institution-report.index', [
                                    'idCompanyInstitution' => $companyInstitution->id,
                                    'nameCompanyInstitution' => str_replace(' ', '-', $companyInstitution->name)
                                ])
                    }}">
                            <img    src="{{ $companyInstitution->photo }}"
                                    alt="{{ $companyInstitution->name }}"
                                    style="height: 200px; width: 200px; margin: 2rem 0 1rem 0;"
                                    class="rounded mx-auto d-block"
                            >
                            {{--                        <div class="text-center">--}}

                            {{--                            <span></span>--}}
                            {{--                        </div>--}}
                        </a>
                        <div class="text-center">
                            <a  href="
                            {{
                                route('administration.company-institution-report.index', [
                                    'idCompanyInstitution' => $companyInstitution->id,
                                    'nameCompanyInstitution' => str_replace(' ', '-', $companyInstitution->name)
                                ])
                            }}
                                " class="btn btn-outline-custom" >
                                <i class="fas fa-search"></i>
                                Ver Informes
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
