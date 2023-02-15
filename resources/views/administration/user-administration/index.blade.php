@extends('administration.layout.dashboard')

@section('content')
    @include('administration.user-administration.section-title')
    <div class="card">
        <div class="card-body">
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
            @foreach($users as $user)
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <h5>Usuario</h5>
                        <p>{{ $user->name }} {{ $user->last_name }}</p>
                        @if($user->hasRole('Administrador'))
                            <span class="badge badge-info text-white">
                                <i class="fas fa-user-cog"></i>
                                Administrador
                            </span>
                        @else
                            <span class="badge badge-info text-white">
                                <i class="fas fa-user"></i>
                                Usuario
                            </span>
                        @endif
                        @if($user->deleted_state == 0)
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
                    <div class="col-12 col-md-6 col-lg-4">
                        <h5 class="pt-3 pt-lg-0">E-mail</h5>
                        <p>{{ $user->email }}</p>
                    </div>
                    <div class="col-lg-4 pt-md-3 pt-lg-0">
                        @if($user->deleted_state == 0)
                            <a  href="{{ route('administration.user-administration.edit', ['id' => $user->id]) }}"
                                class="btn btn-primary"
                            >
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form   method="POST"
                                    action="{{ route('administration.user-administration.destroy', ['id' => $user->id]) }}"
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
                                    action="{{ route('administration.user-administration.restore', ['id' => $user->id]) }}"
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
                <hr>
            @endforeach
            <br>
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
@endsection
