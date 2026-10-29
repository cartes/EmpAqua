@extends('layout.app')

@section("content")

    <div class="container">
        @if (null !== session('message'))
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="alert alert-{{session('message')[0]}}" role="alert">
                        {{session('message')[1]}}
                    </div>
                </div>
            </div>
        @endif

        @include('partials.modals.loginHome')
        @include('partials.modals.loginBusiness')
        @include("partials.modals.register")
        @include('partials.modals.registerBusiness')

    </div>

    <div class="container-fluid container-about">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="my-5">Quienes somos</h3>
                    <p>
                        “Bolsa de Empleos AQUA” es una iniciativa del B2B Group Media SPA, casa editorial de la revista
                        AQUA y del portal www.aqua.cl.
                        Nos hemos propuesto convertirnos en la plataforma de empleo líder en el sector acuícola y
                        pesquero nacional, ofreciendo un eficiente punto de encuentro entre empleadores y
                        potenciales trabajadores de este dinámico sector.
                    </p>
                    <p>
                        Este proyecto nace con el propósito de mejorar la tradicional Bolsa de Trabajo del portal
                        www.aqua.cl, la cual, por más de diez años, prestó un importante servicio a la comunidad
                        acuícola-pesquera local, convirtiéndose en una potente herramienta en términos de búsqueda
                        y oferta de empleos en el sector, especialmente, en las regiones del sur del país.
                    </p>
                    <p>
                        Este año 2020, presentamos el portal laboral, totalmente renovado, donde
                        esperamos prestar un servicio de alta calidad que se adecue a las necesidades tanto de
                        empresas, como de trabajadores que necesitan entrar en conexión.
                    </p>
                    <p>
                        Esta nueva plataforma es una apuesta más del B2B Group Media SPA, y su división AQUA,
                        por seguir apoyando y acompañando el desarrollo del sector acuícola y pesquero. Estamos
                        confiados en que será ampliamente aprovechada por quienes componen el sector.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection