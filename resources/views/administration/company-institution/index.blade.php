@extends('administration.layout.dashboard')

@section('content')
    @include('administration.company-institution.section-title')
    <div class="card">
        <div class="card-body">
            @include('administration.company-institution.search-form')
            @if(Session::has('store'))
                <div class="alert alert-success" role="alert" style="margin-bottom: 1.2rem;">
                    <b>Empresa / Instituci&oacute;n adicionada correctamente</b>
                </div>
            @endif
            @if(Session::has('update'))
                <div class="alert alert-primary" role="alert" style="margin-bottom: 1.2rem;">
                    <b>Empresa / Instituci&oacute;n actualizada correctamente</b>
                </div>
            @endif
            @if(Session::has('destroy'))
                <div class="alert alert-danger" role="alert" style="margin-bottom: 1.2rem;">
                    <b>Empresa / Instituci&oacute;n eliminada correctamente</b>
                </div>
            @endif
            <hr>
            @if($companiesInstitutions->count() > 0)
                @foreach($companiesInstitutions as $companyInstitution)
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-8">
                            <h5>Empresa / Instituci&oacute;n</h5>
                            <p>{{ $companyInstitution->name  }}</p>
                            @if($companyInstitution->deleted_state == 0)
                                <span class="badge badge-success">
                                    <i class="fas fa-check"></i>
                                    Activo
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-trash-alt"></i>
                                    Eliminado
                                </span>
                            @endif
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 col-buttons">
                            <div style="display: inline">
                                <br>
                                @if($companyInstitution->deleted_state == 0)
                                    <a  href="{{ route('administration.company-institution.edit', ['id' => $companyInstitution->id]) }}"
                                        class="btn btn-primary"
                                    >
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form   method="POST"
                                            action="{{ route('administration.company-institution.destroy', ['id' => $companyInstitution->id]) }}"
                                            style="display: inline"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </form>
                                @else
                                    <form   method="POST"
                                            action="{{ route('administration.company-institution.restore', ['id' => $companyInstitution->id]) }}"
                                            style="display: inline"
                                    >
                                        @csrf
                                        @method('PUT')
                                        <button     type="submit"
                                                    class="btn btn-secondary text-white"
                                        >
                                            <i class="fas fa-trash-restore"></i> Restituir
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
                <br>
                {{ $companiesInstitutions->withQueryString()->links() }}
            @else
                <div class="alert alert-info" role="alert">
                    <b>A&uacute;n no se tienen registros de Empresas / Instituciones</b>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/administration/companies-institutions_index.css') }}">
@endsection
