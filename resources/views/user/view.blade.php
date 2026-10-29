@extends('layout.app')
@section('robots', 'noindex, nofollow')

@section('title', 'Mi CV')

@push('styles')
    @include('partials.profile.styles')
    <style>
        .cv-facts { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 1rem 1.5rem; margin: 0; }
        .cv-facts dt { font-size: .75rem; text-transform: uppercase; letter-spacing: .03em; color: #8a8a8a; font-weight: 600; margin: 0; }
        .cv-facts dd { margin: 0; color: #222; word-break: break-word; }
        @media print {
            .no-print, header, footer, nav { display: none !important; }
            .p-card { box-shadow: none; break-inside: avoid; }
            .profile-hero { background: #fff !important; color: #000; border: 1px solid #ccc; }
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4 profile-page">
        @if(session()->has('message'))
            <div class="alert alert-{{ session('message')[0] == 'error' ? 'danger' : session('message')[0] }}" role="alert">
                {{ session('message')[1] }}
            </div>
        @endif

        @include('partials.user.view')
    </div>
@endsection
