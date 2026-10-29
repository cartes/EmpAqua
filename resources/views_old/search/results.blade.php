@extends('layout.app')

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
        @include('partials.modals.loginHome')           {{-- Modals login usuario --}}
        @include('partials.modals.loginBusiness')       {{-- Modals login business --}}
        @include("partials.modals.register")            {{-- Modals registro usuario --}}
        @include('partials.modals.registerBusiness')    {{-- Modals registro business --}}


        @include('partials.offers.result')
    </div>

@endsection

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

