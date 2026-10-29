<div class="navbar-nav menu-mobile w-100">
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
            <li><a class="nav-link" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar Sesión</a></li>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function(){
        $('.dropdown-toggle').dropdown();
    });
</script>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
