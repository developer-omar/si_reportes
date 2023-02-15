<nav    class="navbar navbar-expand-lg navbar-light mb-2 d-none d-sm-none d-md-flex justify-content-md-between"
        style="background-color: #f5f8fb"
>
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('page.report.index') }}">
                <b>
                    <i class="fas fa-arrow-left"></i>
                    Volver a la Pagina Principal
                </b>
            </a>
        </li>
    </ul>

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <b>
                <a  id="navbarDropdown"
                    class="nav-link text-dark"
                    href="#"
                    role="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <i class="fas fa-user-circle"></i>
                    {{ Auth::user()->name }} {{ Auth::user()->last_name }}
                </a>
            </b>
        </li>
    </ul>
</nav>
