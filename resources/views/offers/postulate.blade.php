@extends('layout.app')

@if(is_object($offer))
@section('title', ' | ' . $offer->title)
@endif

@section('content')

    <div class="container-fluid p-0" style="padding-top: 3.75rem !important;">
        @if(session()->has('message'))
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
    @if (is_object($offer))
        <link rel="canonical" href="{{ route('offer.show', ['slug' => $offer->slug]) }}" />

        <meta property="og:image" content="{{ asset('images/1x/logo-empleos-aqua.png') }}" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Empleos Aqua | {{ $offer->title }}" />

        {{-- Oferta de trabajo: JobPosting (solo si está publicada y vigente) --}}
        {!! \App\Support\Schema::script(\App\Support\Schema::jobPosting($offer)) !!}
    @endif
@endpush

@push('scripts')

    <!-- Banner superior -->
    
    <script>
        $(document).ready(function() {
            $('.toast').toast('show');
        });
    </script>

    <script>
      window.googletag = window.googletag || {cmd: []};
      googletag.cmd.push(function() {
        googletag.defineSlot('/18588809/EM_MCH_SKHDS', [120, 600], 'div-gpt-ad-1726238013036-0').addService(googletag.pubads());
        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
      });
    </script>

    <script>
      window.googletag = window.googletag || {cmd: []};
      googletag.cmd.push(function() {
        googletag.defineSlot('/18588809/EM_MCH_SKHIS', [120, 600], 'div-gpt-ad-1726239231348-0').addService(googletag.pubads());
        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
      });
    </script>


    <!-- Fin Banner Superior -->

    <!-- Banner Inferior -->

    <script>
      window.googletag = window.googletag || {cmd: []};
      googletag.cmd.push(function() {
        googletag.defineSlot('/18588809/EM_MCH_SKHDI', [120, 600], 'div-gpt-ad-1726239443747-0').addService(googletag.pubads());
        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
      });
    </script>
    
    <script>
      window.googletag = window.googletag || {cmd: []};
      googletag.cmd.push(function() {
        googletag.defineSlot('/18588809/EM_MCH_SKHII', [120, 600], 'div-gpt-ad-1726239573164-0').addService(googletag.pubads());
        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
      });
    </script>
    <!-- Fin banner Inferior -->


@endpush

@push('styles')
    <style>
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

    </style>
@endpush
