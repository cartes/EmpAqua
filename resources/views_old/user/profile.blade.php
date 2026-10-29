@extends('layout.app')

@section('title', 'Perfil de Usuario')

@section('content')

    <div class="container">
        @if(session()->has('message'))
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="alert alert-{{session('message')[0]}}" role="alert">
                        {{session('message')[1]}}
                    </div>
                </div>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-9">
                @include('partials.profile.personal')
                {{--@include('partials.profile.resume')--}}
                @include('partials.profile.experience')
                @include('partials.profile.education')
                @include('partials.profile.skills')
                @include('partials.profile.references')
                {{--@include('partials.profile.contact')--}}
            </div>
            <div class="col-md-3 py-3">
                <h3></h3>
            </div>
        </div>
        {{--@include('partials.profile.languages')--}}

    </div>

@endsection

@push('scripts')
<script>
    jQuery(document).ready(function($) {
        $(".badge-skills").click(function (event) {

            event.preventDefault();
            if (confirm('¿Desea borrar esta habilidad de su listado?')) {
                const id = $(this).data('id');
                $.ajax({
                   method: 'DELETE',
                   url: '/profile/api/eraseSkill',
                   data: {
                       "id": id,
                       "_token": "{{ csrf_token() }}",
                   },
                   success: function(data) {
                       location.reload();
                   }
                });
            }
        })
        $(".erase-experience").click(function (event) {
            event.preventDefault();
            if (confirm('¿Desea borrar esta experiencia laboral?')) {
                const id = $(this).data('id');
                $.ajax({
                   method: 'DELETE',
                   url: '/profile/api/eraseExp',
                   data: {
                       "id": id,
                       "_token": "{{ csrf_token() }}",
                   },
                   success: function(data) {
                       location.reload();
                   }
                });
            }
        });
        
        $(".erase-education").click(function (event) {
            event.preventDefault();
            if (confirm('¿Desea borrar esta información académica?')) {
                const id = $(this).data('id');
                $.ajax({
                   method: 'DELETE',
                   url: '/profile/api/eraseEducation',
                   data: {
                       "id": id,
                       "_token": "{{ csrf_token() }}",
                   },
                   success: function(data) {
                       location.reload();
                   }
                });
            };
        });

        $(".erase-reference").click(function (event) {
            event.preventDefault();
            if (confirm('¿Desea borrar esta referencia?')) {
                const id = $(this).data('id');
                $.ajax({
                   method: 'DELETE',
                   url: '/profile/api/eraseReference',
                   data: {
                       "id": id,
                       "_token": "{{ csrf_token() }}",
                   },
                   success: function(data) {
                       location.reload();
                   }
                });
            };
        });
    })
</script>
@endpush