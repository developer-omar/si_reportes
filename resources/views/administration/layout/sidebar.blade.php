<nav class="sidebar navbar navbar-expand-md navbar-dark flex-column d-none d-sm-none d-md-block">
    <div class="sidebar-container">
        <div class="sidebar-header">
            <a href="{{ url('/') }}" class="company-name">
                {{ config('app.name', 'Inbustrade') }}
            </a>
        </div>
        <div class="sidebar-body">
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administration.index.index') }}">
                        <i class="fas fa-home sidebar-icon"></i>
                        <span>Inicio</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administration.user-profile.show') }}">
                        <i class="fas fa-user sidebar-icon"></i>
                        <span>Perfil de usuario</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administration.change-password.edit') }}">
                        <i class="fas fa-lock sidebar-icon"></i>
                        <span>Cambiar Password</span>
                    </a>
                </li>

            </ul>
            <hr class="hr">
            <ul class="navbar-nav flex-column">
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
            </ul>
            @if(
                    auth()->user()->can('company_institution') ||
                    auth()->user()->can('subsidiary') ||
                    auth()->user()->can('report') ||
                    auth()->user()->can('user')
            )
            <hr class="hr">
            @endif
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a  class="nav-link" href="{{ route('auth.login.user-administration-logout') }}">
                        <i class="fas fa-sign-out-alt sidebar-icon"></i>
                        <span>Cerrar Sesi&oacute;n</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
