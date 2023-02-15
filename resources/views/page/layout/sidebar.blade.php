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
                    <a class="nav-link" href="{{ route('page.user-company-institution-profile.show') }}">
                        <i class="fas fa-user sidebar-icon"></i>
                        <span>Perfil de usuario</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('page.change-password.edit') }}">
                        <i class="fas fa-lock sidebar-icon"></i>
                        <span>Cambiar Password</span>
                    </a>
                </li>

            </ul>
            <hr class="hr">
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a  class="nav-link"
                        href="{{ route('auth.login.user-company-institution-logout') }}"
                    >
                        <i class="fas fa-sign-out-alt sidebar-icon"></i>
                        <span>Cerrar Sesi&oacute;n</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
