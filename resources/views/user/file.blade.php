@extends('layout.app')
@section('robots', 'noindex, nofollow')

@section('content')
    @if(in_array(session()->get('role'), ['business', 'administrador'], true))
        <div class="container">
            @include('partials.user.file')
        </div>
    @endif
@endsection