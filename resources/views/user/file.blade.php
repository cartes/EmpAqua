@extends('layout.app')
@section('robots', 'noindex, nofollow')

@section('content')
    @if(session()->get('role') == 'business')
        <div class="container">
            @include('partials.user.file')
        </div>
    @endif
@endsection