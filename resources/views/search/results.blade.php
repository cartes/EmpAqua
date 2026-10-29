@extends('layout.app')
@section('robots', 'noindex, nofollow')

@section('content')
    <div class="container py-sm-5">
        <div class="row justify-content-between">
            <div class="col-md-6 align-self-start">
                <form class="form-inline my-4 my-lg-0" method="post" action="{{ route('search') }}" >
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
                        <button class="btn btn-primary btn-block">Destacadas</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        @include('partials.modals.loginHome')           {{-- Modals login usuario --}}
        @include('partials.modals.loginBusiness')       {{-- Modals login business --}}
        @include("partials.modals.register")            {{-- Modals registro usuario --}}
        @include('partials.modals.registerBusiness')    {{-- Modals registro business --}}


        @include('partials.offers.result')
    </div>

@endsection

        @push('scripts')
        <!-- Banner superior -->
            <script>
                window.googletag = window.googletag || {cmd: []};
                googletag.cmd.push(function () {
                    googletag.defineSlot('/18588809/EASKHDS', [120, 600], 'div-gpt-ad-1620410987480-0').addService(googletag.pubads());
                    googletag.pubads().enableSingleRequest();
                    googletag.enableServices();
                });
            </script>

            <script>
                window.googletag = window.googletag || {cmd: []};
                googletag.cmd.push(function () {
                    googletag.defineSlot('/18588809/EASKHIS', [120, 600], 'div-gpt-ad-1620410792403-0').addService(googletag.pubads());
                    googletag.pubads().enableSingleRequest();
                    googletag.enableServices();
                });
            </script>
            <!-- Fin Banner Superior -->

            <!-- Banner Inferior -->

            <script>
                window.googletag = window.googletag || {cmd: []};
                googletag.cmd.push(function () {
                    googletag.defineSlot('/18588809/EASKHDI', [120, 600], 'div-gpt-ad-1620411032581-0').addService(googletag.pubads());
                    googletag.pubads().enableSingleRequest();
                    googletag.enableServices();
                });
            </script>


            <script>
                window.googletag = window.googletag || {cmd: []};
                googletag.cmd.push(function () {
                    googletag.defineSlot('/18588809/EASKHII', [120, 600], 'div-gpt-ad-1620410914897-0').addService(googletag.pubads());
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
                                'top': 'auto',
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
                @media (min-width: 475px) {

                    .container {
                        max-width: 1300px;
                    }
                }

                .skyscrapper {
                    width: 120px;
                    height: 600px;
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

