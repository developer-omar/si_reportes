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
                    <a class="nav-link" href="/">
                        <i class="fas fa-home sidebar-icon"></i>
                        <span>Pagina Principal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('page.user-company-institution-profile.show') }}">
                        <i class="fas fa-user sidebar-icon"></i>
                        <span>Perfil de Usuario</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('page.change-password.edit') }}">
                        <i class="fas fa-lock sidebar-icon"></i>
                        <span>Cambiar Password</span>
                    </a>
                </li>
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
