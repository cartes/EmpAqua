@extends('layout.app')

@section('content')
    @if(session()->get('role') == 'business')
        <div class="container">
            @if(session()->has('message'))
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="alert alert-{{session('message')[0]}}" role="alert">
                            {{session('message')[1]}}
                        </div>
                    </div>
                </div>
            @endif

            @include('partials.user.file')
        </div>
    @endif
@endsection