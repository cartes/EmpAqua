@extends('layout.app')

@if(is_object($offer))
@section('title', ' | ' . $offer->title)
@endif

@section('content')

    <div class="container-fluid">
        <!-- /18588809/EASKHDS -->
        <div class="container position-relative">
            <div class="container skyscrapper container-left superior position-absolute" style="left: 101%">
                <div class="position-absolute" id='div-gpt-ad-1620410987480-0'
                     style='z-index: 100; width: 120px; height: 600px;'>
                    <script>
                        googletag.cmd.push(function () {
                            googletag.display('div-gpt-ad-1620410987480-0');
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="container position-relative">
            <div class="container skyscrapper container-left inferior position-absolute" style="left: 101%">
                <!-- /18588809/EASKHDI -->
                <div class="position-absolute" id='div-gpt-ad-1620411032581-0'
                     style='z-index: 10; width: 120px; height: 600px;'>
                    <script>
                        googletag.cmd.push(function () {
                            googletag.display('div-gpt-ad-1620411032581-0');
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="container position-relative">
            <div class="container skyscrapper container-right superior position-absolute" style="left: -12%">
                <!-- /18588809/EASKHIS -->
                <div id='div-gpt-ad-1620410792403-0' style='z-index: 100; width: 120px; height: 600px;'>
                    <script>
                        googletag.cmd.push(function () {
                            googletag.display('div-gpt-ad-1620410792403-0');
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="container position-relative">
            <div class="container skyscrapper container-right inferior position-absolute" style="left: -12%">
                <!-- /18588809/EASKHII -->
                <div id='div-gpt-ad-1620410914897-0' style='z-index: 10; width: 120px; height: 600px;'>
                    <script>
                        googletag.cmd.push(function () {
                            googletag.display('div-gpt-ad-1620410914897-0');
                        });
                    </script>
                </div>
            </div>
        </div>

        @if(session()->has('message'))
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="alert alert-{{session('message')[0]}}" role="alert">
                        {{session('message')[1]}}
                    </div>
                </div>
            </div>
        @endif

        @include("partials.modals.loginHome")
        @include("partials.modals.loginBusiness")
        @include("partials.modals.register")            {{-- Modals registro usuario --}}
        @include('partials.modals.registerBusiness')    {{-- Modals registro business --}}

        @include("partials.offers.postulate")

        <div class="modal fade" id="postuleModal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content py-3 px-4">
                    <div class="modal-header">
                        <h4>Deseas postular al aviso {{ $offer->title ?? '' }}</h4>
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
                                <a class="btn btn-primary" href="{{ route('offer.postulate', $offer->slug) }}">Postular</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@push('meta')
    <link rel=“canonical” href=“{{ route('offer.show', ['slug' => $offer->slug ])}}” />

    <meta property=”og:image” content=”https://www.empleosaqua.cl/images/1x/logo-empleos-aqua.png” />
    <meta property=”og:type” content=”article” />
    <meta property=”og:title” content=”Empleos Aqua | {{ $offer->title }}” />
@endpush

@push('scripts')

    <!-- Banner superior -->
    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
    <script>
        window.googletag = window.googletag || {cmd: []};
        googletag.cmd.push(function () {
            googletag.defineSlot('/18588809/EASKHDS', [120, 600], 'div-gpt-ad-1620410987480-0').addService(googletag.pubads());
            googletag.pubads().enableSingleRequest();
            googletag.enableServices();
        });
    </script>

    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
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
    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>

    <script>
        window.googletag = window.googletag || {cmd: []};
        googletag.cmd.push(function () {
            googletag.defineSlot('/18588809/EASKHDI', [120, 600], 'div-gpt-ad-1620411032581-0').addService(googletag.pubads());
            googletag.pubads().enableSingleRequest();
            googletag.enableServices();
        });
    </script>

    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>

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
                let halfBody = parseInt(cuerpo.height() / 2) - 600;

                if (position > 143) {
                    a('.skyscrapper').find('div').css({
                        'position': 'fixed',
                        'top': '120px'
                    });
                } else {
                    a('.skyscrapper').find('div').css({
                        'position': 'absolute',
                        'top': 'auto'
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
                max-width: 985px;
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

    </style>
@endpush
