@extends('administration.layout.dashboard')

@section('content')
    @include('administration.subsidiary.section-title')
    <div class="card">
        <div class="card-body">
            @include('administration.subsidiary.search-form')
            @if(Session::has('store'))
                <div class="alert alert-success" role="alert" style="margin-bottom: 1.2rem;">
                    <b>Sucursal adicionada correctamente</b>
                </div>
            @endif
            @if(Session::has('update'))
                <div class="alert alert-primary" role="alert" style="margin-bottom: 1.2rem;">
                    <b>Sucursal actualizada correctamente</b>
                </div>
            @endif
            @if(Session::has('destroy'))
                <div class="alert alert-danger" role="alert" style="margin-bottom: 1.2rem;">
                    <b>Sucursal eliminada correctamente</b>
                </div>
            @endif

            <hr>
            @if($subsidiaries->count() > 0)
                @foreach($subsidiaries as $subsidiary)
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-8">
                            <div class="row">
                                <div class="col-6 col-md-7">
                                    <h5>Sucursal</h5>
                                </div>
                                <div class="col-6 col-md-5">
                                    <h5 class="d-block d-md-none d-lg-block">Empresa / Instituci&oacute;n</h5>
                                    <!-- Only for tablet -->
                                    <h5 class="d-none d-md-block d-lg-none">
                                        Emp. / Inst.
                                    </h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-7">
                                    <p>{{ $subsidiary->name  }}</p>
                                    @if($subsidiary->deleted_state == 0)
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
                                <div class="col-6 col-md-5">
                                    <p>{{ $subsidiary->companyInstitution->name }}</p>
                                    <b><p>{{ $subsidiary->city->name }}</p></b>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="row">
                                <div class="col-12 col-buttons">
                                    <div style="display: inline;">
                                        @if($subsidiary->deleted_state == 0)
                                            <a  href="{{ route('administration.subsidiary.edit', ['id' => $subsidiary->id]) }}"
                                                class="btn btn-primary"
                                            >
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <form   method="POST"
                                                    action="{{ route('administration.subsidiary.destroy', ['id' => $subsidiary->id]) }}"
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
                                        @else
                                            <form   method="POST"
                                                    action="{{ route('administration.subsidiary.restore', ['id' => $subsidiary->id]) }}"
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

                        </div>
                    </div>
                    <hr>
                @endforeach
                <br>
                {{ $subsidiaries->withQueryString()->links() }}
            @else
                <div class="alert alert-info" role="alert">
                    <b>A&uacute;n no se tienen registros de Sucursales</b>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/administration/subsidiaries_index.css') }}">
@endsection
