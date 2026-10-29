@extends("layout.app")

@section("content")
    <div class="container-fluid p-0">
        <div class="container position-relative d-none d-md-block">
            <!-- /18588809/EM_MCH_SKHDS -->
            <div class="container skyscrapper container-left superior position-absolute" style="left: 101%">
                <div id='div-gpt-ad-1726238013036-0' style='min-width: 120px; min-height: 600px; position: absolute;'>
                    <script>
                        googletag.cmd.push(function() {
                            googletag.display('div-gpt-ad-1726238013036-0');
                        });
                    </script>
                </div>

            </div>
        </div>

        <div class="container position-relative d-none d-md-block">
            <div class="container skyscrapper container-left inferior position-absolute" style="left: 101%">
                <!-- /18588809/EM_MCH_SKHDI -->
                <div id='div-gpt-ad-1726239443747-0' style='min-width: 120px; min-height: 600px;'>
                    <script>
                        googletag.cmd.push(function() {
                            googletag.display('div-gpt-ad-1726239443747-0');
                        });
                    </script>
                </div>

            </div>
        </div>

        <div class="container position-relative d-none d-md-block">
            <div class="container skyscrapper container-right superior position-absolute" style="left: -18%">
                <!-- /18588809/EM_MCH_SKHIS -->
                <div id='div-gpt-ad-1726239231348-0' style='min-width: 120px; min-height: 600px;'>
                    <script>
                        googletag.cmd.push(function() {
                            googletag.display('div-gpt-ad-1726239231348-0');
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="container position-relative d-none d-md-block">
            <div class="container skyscrapper container-right inferior position-absolute" style="left: -18%">
                <!-- /18588809/EM_MCH_SKHII -->
                <div id='div-gpt-ad-1726239573164-0' style='min-width: 120px; min-height: 600px;'>
                    <script>
                        googletag.cmd.push(function() {
                            googletag.display('div-gpt-ad-1726239573164-0');
                        });
                    </script>
                </div>

            </div>
        </div>
    </div>

    @if(null!==session('message'))
        <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 1rem; right: 1rem; z-index: 1050;">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                <div class="toast-header bg-{{ session('message')[0] }} text-white">
                    <strong class="mr-auto">Notificación</strong>
                    <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    {{ session('message')[1] }}
                </div>
            </div>
        </div>
    @endif


    @include('partials.modals.loginHome')           {{-- Modals login usuario --}}
    @include('partials.modals.loginBusiness')       {{-- Modals login business --}}
    @include("partials.modals.register")            {{-- Modals registro usuario --}}
    @include('partials.modals.registerBusiness')    {{-- Modals registro business --}}

    {{-- Sección con busqueda --}}
    <div class="container py-sm-5">
        <div class="row justify-content-between">
            <div class="col-md-6 align-self-start">
                <form class="form-inline my-4 my-lg-0" method="post" action="{{ route('search') }}">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-briefcase"></i></span>
                        <input class="form-control" type="text" name="query" placeholder="Buscar ofertas de empleo"
                               aria-label="Search">
                        <button class="btn my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-md-5 align-self-end">
                <div class="row-buttons row">
                    <div class="col-12 col-sm-6">
                        <a href="{{ route('offer.list') }}" class="btn mb-3 mb-sm-0 btn-primary btn-block">Todas las ofertas</a>
                    </div>
                    <div class="col-12 col-sm-6 mb-4 mb-sm-0">
                        <a href="{{ route('offer.featured') }}" class="btn btn-primary btn-block">Destacadas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('partials.offers.result')  {{-- Listado de oferrtas laborales--}}


    <div class="modal fade" id="postuleModal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content py-3 px-4">
                <div class="modal-header">
                    <h4>Deseas postular al aviso {{ $offers[0]->title ?? '' }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 text-right">
                            <a href="#" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                                Cancelar
                            </a>
                        </div>
                        <div class="col-md-6 text-left">
                            @if ($offers->isNotEmpty())
                                <a class="btn btn-primary" href="{{ route('offer.postulate', $offers[0]->slug) }}">Postular</a>
                            @else
                                <p>Sin ofertas para postular</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('meta')
    <link rel="canonical" href="{{ route('offer.list') }}" />

    <meta property="og:image" content="{{ asset('images/1x/logo-empleos-aqua.png') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Empleos Aqua | Ofertas de trabajo" />

    {!! \App\Support\Schema::script(\App\Support\Schema::itemList($offers)) !!}


@endpush

@push('scripts')

    <script>
        $(document).ready(function() {
            $('.toast').toast('show');
        });
    </script>

    <script>
        window.googletag = window.googletag || {
            cmd: []
        };
        googletag.cmd.push(function() {
            googletag.defineSlot('/18588809/EM_MCH_HA1', [940, 90], 'div-gpt-ad-1726237634232-0').addService(
                googletag.pubads());
            googletag.pubads().enableSingleRequest();
            googletag.enableServices();
        });
    </script>



    <!-- Banner superior -->
    <script>
        window.googletag = window.googletag || {
            cmd: []
        };
        googletag.cmd.push(function() {
            googletag.defineSlot('/18588809/EM_MCH_SKHDS', [120, 600], 'div-gpt-ad-1726238013036-0').addService(
                googletag.pubads());
            googletag.pubads().enableSingleRequest();
            googletag.enableServices();
        });
    </script>


    <script>
        window.googletag = window.googletag || {
            cmd: []
        };
        googletag.cmd.push(function() {
            googletag.defineSlot('/18588809/EM_MCH_SKHIS', [120, 600], 'div-gpt-ad-1726239231348-0').addService(
                googletag.pubads());
            googletag.pubads().enableSingleRequest();
            googletag.enableServices();
        });
    </script>

    <!-- Fin Banner Superior -->

    <!-- Banner Inferior -->
    <script>
        window.googletag = window.googletag || {
            cmd: []
        };
        googletag.cmd.push(function() {
            googletag.defineSlot('/18588809/EM_MCH_SKHDI', [120, 600], 'div-gpt-ad-1726239443747-0').addService(
                googletag.pubads());
            googletag.pubads().enableSingleRequest();
            googletag.enableServices();
        });
    </script>



    <script>
        window.googletag = window.googletag || {
            cmd: []
        };
        googletag.cmd.push(function() {
            googletag.defineSlot('/18588809/EM_MCH_SKHII', [120, 600], 'div-gpt-ad-1726239573164-0').addService(
                googletag.pubads());
            googletag.pubads().enableSingleRequest();
            googletag.enableServices();
        });
    </script>

    <!-- Fin banner Inferior -->


    <script>
        jQuery(document).ready(function (a) {
            var faded = false;
            a(window).scroll(function fix_element() {
                let position = a(window).scrollTop();
                let container = a('.skyscrapper.superior').find('div');
                let cuerpo = a('body');
                let halfBody = parseInt(cuerpo.height() / 2) + 600;

                if (position > 212) {
                    a('.skyscrapper').find('div').css({
                        'position': 'fixed',
                        'top': '120px'
                    });
                } else {
                    a('.skyscrapper').find('div').css({
                        'position': 'absolute',
                        'top': '125px',
                    });
                }

                if (!faded) {
                    if (halfBody < position) {
                        container.fadeOut(150);
                        faded = true;
                    }
                }

                if (halfBody > position) {
                    if (faded) {
                        container.fadeIn(100);
                        faded = false;
                    }
                }

            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .skyscrapper {
            width: 120px;
            height: 600px;
        }

        .skyscrapper div {
            position: absolute;
            top: 125px;
        }

        .inferior {
            z-index: 10;
        }

        .superior {
            z-index: 100;
        }
        .container-offer a {
            color: #fff;
        }
        .container-offer {
            background-color: #3490dc;
        }
        p, p > * {
            font-family: Nunito,sans-serif !important;
            font-size: .9rem !important;
            font-weight: 400 !important;
            line-height: 1.6 !important;
        }
    </style>
@endpush
