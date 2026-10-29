<div class="navbar-nav ms-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{ route("user.offers") }}">Mis Postulaciones</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route("user.favorites") }}">Mis Favoritos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route("profile.view") }}">Ver mi CV</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('profile') }}">Modificar mi CV</a>
    </li>

    <div class="dropdown">
        <button class="btn dropdown-toggle ml-auto" type="button" id="dropDownUser"
                data-toggle="dropdown" aria-expanded="false"
                aria-haspopup="true">{{session()->get('name') ?? ''}}</button>
        <div class="dropdown-menu" aria-labelledby="dropDownUser">
            <li>
                <a class="nav-link" href="{{route('profile')}}">Mi perfil</a>
            </li>
            <li><a class="nav-link" href="{{route('logout')}}">Cerrar Sesión</a></li>
        </div>
    </div>
</div>
