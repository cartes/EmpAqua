<ul class="navbar-nav ms-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{ route("about") }}">
            Quienes somos
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('faq') }}">
            Preguntas Frecuentes
        </a>
    </li>
    <li>
        <a class="nav-link" href="{{asset('/images/media_kit_2022.pdf')}}" target="_blank">
            Mediakit
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('terms') }}">
            Términos y condiciones
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('contactPage') }}">
            Contacto
        </a>
    </li>
</ul>
<div class="d-none d-sm-inline-block">
    <a class="btn btn-access-border ml-4" href="#" data-toggle="modal" data-target="#loginUserModal">
        Acceso Postulante
    </a>
    <a class="btn btn-access" data-toggle="modal" data-target="#loginBusiness">
        Acceso Empresa
    </a>
</div>
