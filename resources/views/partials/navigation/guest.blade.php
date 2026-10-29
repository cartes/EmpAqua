<ul class="navbar-nav menu-mobile">
    <li class="nav-item">
        <a class="nav-link" href="{{ route("about") }}">
            Nosotros
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('faq') }}">
            Preguntas Frecuentes
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{asset('/images/MediaKit2023.pdf')}}" target="_blank">
            Mediakit
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('prices') }}">
            Tarifas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('contactPage') }}">
            Contacto
        </a>
    </li>
</ul>

<!-- Botones de acceso para pantallas grandes y tablets -->
<div class="d-none d-sm-inline-block">
    <a class="btn btn-access" data-toggle="modal" data-target="#loginBusiness">
        Acceso Empresa
    </a>
    <a class="btn btn-access-border" href="#" data-toggle="modal" data-target="#loginUserModal">
        Acceso Postulante
    </a>
</div>

<!-- Botón de acceso para pantallas muy pequeñas (celulares) -->
<div class="d-sm-none text-center d-flex justify-content-end">
    <a class="btn btn-outline-info" href="#" data-toggle="modal" data-target="#loginUserModal">
        Acceso Postulante
    </a>
</div>
