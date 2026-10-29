<div class="navbar-nav ms-auto">
    <a class="btn" href="{{ route('post.create') }}" type="button">Publicar oferta</a>
    <a class="nav-link" href="{{ route('business.roles') }}">Administrar Roles</a>
    <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="dropDownUser"
                data-toggle="dropdown" aria-expanded="false"
                aria-haspopup="true">{{\Illuminate\Support\Str::limit(session()->get('name'), 20) ?? ''}}
        </button>
        <div class="dropdown-menu" aria-labelledby="dropDownUser">
            <a class="nav-link text-white" href="{{ route('business.profile') }}">Perfil Empresa</a>
            <a class="nav-link text-white" href="{{ route('offer.admin') }}">Administrar Ofertas</a>
            <div class="dropdown-divider" style="border-top-color: #fff;"></div>
            <a class="nav-link text-white" href="{{ route('logout') }}">Cerrar Sesión</a>
        </div>
    </div>
</div>
