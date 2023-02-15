<nav    class="navbar navbar-expand-lg navbar-dark d-block d-sm-block d-md-none mb-3"
        style="background-color: #262b40"
>
    <div class="container">
        <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
        <button     class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administration.index.index') }}">
                        <i class="fas fa-home sidebar-icon"></i>
                        <span>Inicio</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administration.user-profile.show') }}">
                        <i class="fas fa-user sidebar-icon"></i>
                        <span>Perfil de Usuario</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administration.change-password.edit') }}">
                        <i class="fas fa-lock sidebar-icon"></i>
                        <span>Cambiar Password</span>
                    </a>
                </li>
                @can('company_institution')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administration.company-institution.index') }}">
                        <i class="fas fa-building sidebar-icon"></i>
                        <span>Empresas / Instituciones</span>
                    </a>
                </li>
                @endcan
                @can('subsidiary')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administration.subsidiary.index') }}">
                        <i class="fas fa-store sidebar-icon"></i>
                        <span>Sucursales</span>
                    </a>
                </li>
                @endcan
                @can('report')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administration.my-report.index') }}">
                        <i class="far fa-clipboard sidebar-icon"></i>
                        <span>Mis Informes</span>
                    </a>
                </li>
                @endcan
                @can('user_administration')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administration.user-administration.index') }}">
                        <i class="fas fa-users-cog sidebar-icon"></i>
                        <span>Usuarios Inbustrade</span>
                    </a>
                </li>
                @endcan
                @can('user_company_institution')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('administration.user-company-institution.index') }}">
                            <i class="fas fa-users sidebar-icon"></i>
                            <span>Usuarios Emp. / Inst.</span>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a  class="nav-link"
                        href="{{ route('auth.login.user-administration-logout') }}"
                    >
                        <i class="fas fa-sign-out-alt sidebar-icon"></i>
                        <span>Cerrar Sesi&oacute;n</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
