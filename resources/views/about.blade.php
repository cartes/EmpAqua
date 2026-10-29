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
                <div class="col-md-8 offset-2 text-center">
                    <img class="w-25 my-5 text-center" src="{{asset('/images/1x/logo-empleos-aqua.png')}}" />
                    <h3 class="my-5 text-center">Quienes somos</h3>
                    <p>
                        “EmpleosAqua” es una iniciativa de B2B Group Media SPA, casa editorial de la revista AQUA y del
                        portal www.aqua.cl. Nos hemos propuesto convertirnos en la plataforma de empleo líder en el
                        sector acuícola pesquero nacional y de otros sectores productivos, ofreciendo un eficiente punto
                        de encuentro entre empleadores y potenciales trabajadores.
                    </p>
                    <p>
                        Este proyecto nace con el propósito de mejorar la tradicional bolsa de trabajo del portal
                        www.aqua.cl. La cual, por más de diez años, prestó un importante servicio a la comunidad
                        acuícola pesquera local, convirtiéndose en una potente herramienta en términos de búsqueda y
                        oferta de empleos. Especialmente, en la región sur del país.
                    </p>
                    <p>
                        Presentamos el portal laboral totalmente renovado, donde esperamos prestar un servicio de alta
                        calidad que se adecue a las necesidades de empresas y trabajadores que necesitan entrar en
                        conexión.
                    </p>
                    <p>
                        Esta nueva plataforma es una apuesta más de B2B Group Media SPA, y su división AQUA, por seguir
                        apoyando y acompañando el desarrollo productivo. Estamos confiados que será ampliamente
                        aprovechada por quienes componen estos sectores.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
