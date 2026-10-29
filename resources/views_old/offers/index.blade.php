@extends('layout.app')

@section('content')
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

        {{-- Modals --}}

        @include('partials.modals.republishOffer')


        {{-- Zona de info de empresa --}}
        <div class="row justify-content-center mb-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="row justify-content-center">
                                    <div class="col-md-6 mb-4">
                                        <div class="container-logo-img mx-auto">
                                            <img class="logo-img h-100 w-auto"
                                                 src="{{ $business->business_meta->pathAttachment() }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h4 class="text-uppercase">{{ $business->business_meta->business_name }}</h4>
                                        <a class="btn btn-outline-primary" href="{{ route('business.profile') }}">Actualizar
                                            mi perfil</a>
                                        <h5 class="small mt-5">Role: {{session()->get('role_id')}}</h5>

                                    </div>
                                </div>
                            </div>
                            <div class="border-left col-md-5">
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <h5>Información de contacto</h5>
                                        <p class="py-0 my-0">
                                            Nombre: {{ $business->firstname }} {{ $business->surname }}</p>
                                        <p class="py-0 my-0">Email: {{ $business->email_user }}</p>
                                        <p class="pt-0 my-0">Teléfono: {{ $business->phone_user }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h5>Información de contacto empresa</h5>
                                        <p class="py-0 my-0">Email: {{ $business->business_meta->email }}</p>
                                        <p class="pt-0 my-0">Teléfono: {{ $business->business_meta->phone }}</p>
                                        <p class="pt-0 my-0">Rubro: {{ $business->business_meta->activity }}</p>
                                        <p class="pt-0 my-0">Dirección: {{ $business->business_meta->address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @if (session()->has('exp_role')) 
                <div class="card">
                    <div class="card-body{{session()->get('exp_role') <= 5 ? ' bg-danger' : ' bg-success'}}">
                        <h4 class="text-light">A tu suscripción le quedan: {{session()->get('exp_role')}} {{session()->get('exp_role') <= 1 ? 'Día' : 'Días'}}</h4>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="row justify-content-between mb-0">
            <div class="col-4 m-0">
                @if (session()->has('ads') && session()->get('role_id') != '90')
                    <p>Te quedan <span id="featured"
                                       style="color: #D88F32; font-weight: 700">{{session()->get('ads')}}</span> avisos
                        destacados</p>
                @else
                    <p>Tu membresía no tiene avisos destacados</p>
                @endif
                <h6 class="p-0 m-0"><strong>Ofertas activas</strong></h6>
            </div>
            <div class="col-3 text-right">
                <a href="{{ route('post.create') }}" class="w-100 btn btn-primary text-uppercase text-left"
                   style="line-height: 20px">
                    <i style="font-size: 40px; float: left;" class="mr-3 far fa-plus-square"></i>Publicar<br/> Oferta
                </a>
            </div>
        </div>

        @if($offers->count() > 0)
            <div class="row justify-content-end">
                <div class="col-md-12 offers-file mt-0">
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                    <table class="table-offers table-striped table my-4">
                        <thead>
                        <tr>
                            <th scope="col">Destacado</th>
                            <th scope="col"><p class="m-0 text-center">ID</p></th>
                            <th scope="col"><p class="m-0 text-left">Nombre de la oferta</p></th>
                            <th scope="col"><p class="m-0 text-center">Visualizaciones</p></th>
                            <th scope="col"><p class="m-0 text-right"><i class="h4 p-0 m-0 fas fa-file-alt"></i>
                            </th>
                            <th scope="col"><p class="m-0 text-center">Estatus de la oferta</p></th>
                            <th scope="col"><p class="m-0 text-center">Fecha inicio</p></th>
                            <th scope="col"><p class="m-0 text-center">Fecha termino</p></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            if (session()->get('role_id') == '90' || is_null(session()->get('role_id'))) {
                                $i = 0;
                            } else {
                                $i = 1;
                            }
                        @endphp
                        @foreach($offers as $of)
                            <tr 
                            @if ($of->published == '0') class="bg-warning" @endif
                            @php
                                if(session()->get('role_id') == '90' || is_null(session()->get('role_id'))) {
                                    if ($i > 0) {
                                        echo 'class="info" style="opacity: 0.5;"';
                                    }
                                }

                            @endphp>
                                <td>
                                    @if($of->published == '1')
                                    <div class="text-center">
                                        @if (session()->get('role_id') != '90' || is_null(session()->get('role_id')))
                                            <input type="checkbox"
                                                   class="featured" {{($of->featured === 1) ? 'checked="checked"' : ''}}/>
                                            <input type="hidden" name="id" value="{{$of->id}}"/>
                                        @endif
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    <p class="m-0 text-left">
                                        {{$of->id}}
                                    </p>
                                </td>
                                <td style="width: 400px;">
                                    <p class="m-0 text-left">
                                    @if (session()->get('role_id') == '90' || is_null(session()->get('role_id')))
                                            @if ($i > 0)
                                                {{$of->title}}
                                            @else
                                                <a href="{{ route('offer.detail', $of->slug) }}">
                                                    {{$of->title}}
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route('offer.detail', $of->slug) }}">
                                                {{$of->title}}
                                            </a>
                                        @endif
                                    </p>
                                </td>
                                <td>
                                    <p class="text-center">{{ $of->visit ?? '0' }}</p>
                                </td>
                                <td>
                                    @if($of->candidates_count > 0)
                                        <a href="{{ route('offer.candidates', $of->slug) }}">
                                            <p class="m-0 text-right">{{$of->candidates_count}}</p>
                                        </a>
                                    @else
                                        <p class="m-0 text-right">
                                            Sin candidatos
                                        </p>
                                    @endif
                                </td>
                                <td>
                                    <p class="m-0 text-center">{!! $of->status !!}</p>
                                </td>
                                <td>
                                    <p class="m-0 text-center">{{$of->date}}</p>
                                </td>
                                <td>
                                    <p class="m-0 text-center">{{$of->expiration_date}}</p>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <p>
                                        <a href="{{ route('offer.detail', $of->slug) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </p>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-6">
                                            @if ($of->published == '1')
                                            <form method="post" action="{{ route('offer.unpublish', $of->slug) }}">
                                                @csrf
                                                <button class="w-100 btn-sm btn btn-warning" type="submit">Ocultar</button>
                                            </form>
                                            @else
                                            <form method="post" action="{{ route('offer.republish', $of->slug) }}">
                                                @csrf
                                                <button class="w-100 btn-sm btn btn-success" type="submit">Mostrar</button>
                                            </form>
                                            @endif

                                        </div>
                                        <div class="col-6">
                                            <form method="post" action="{{ route('offer.delete', $of->slug) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-sm btn btn-danger" type="submit">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @php
                            $i++;
                            @endphp
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="row justify-content-center">
                {{ $offers->links() }}
            </div>
        @endif
        @if ($expired->count() > 0)
            <div class="row justify-content-between mb-0">
                <div class="col-4 m-0">
                    <h6 class="m-0 p-0"><strong>Ofertas cerradas</strong></h6>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 offers-file mt-0">
                    <table class="table-offers table-striped table my-4">
                        <thead>
                        <tr>
                            <th scope="col"><p class="m-0 text-left">Nombre de la oferta</p></th>
                            <th scope="col"><p class="m-0 text-right"><i class="h4 p-0 m-0 far fa-eye"></i></p></th>
                            <th scope="col"><p class="m-0 text-right"><i class="h4 p-0 m-0 fas fa-file-alt"></i></p>
                            </th>
                            <th scope="col"><p class="m-0 text-center">Estatus de la oferta</p></th>
                            <th scope="col"><p class="m-0 text-center">Fecha inicio</p></th>
                            <th scope="col"><p class="m-0 text-center">Fecha termino</p></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expired as $exp)
                            <tr  @if ($exp->published == '0') class="bg-warning" @endif>
                                <td>
                                    {{ $exp->title }}
                                </td>
                                <td>
                                    <p>{{ $exp->views }}</p>
                                </td>
                                <td>
                                    @if($exp->candidates_count > 0)
                                        <a href="{{ route('offer.candidates', $exp->slug) }}">
                                            <p class="m-0 text-right">{{$exp->candidates_count}}</p>
                                        </a>
                                    @else
                                        <p class="m-0 text-right">
                                            Sin candidatos
                                        </p>
                                    @endif

                                </td>
                                <td>
                                    <p class="text-center m-0">{!! $exp->status  !!}</p>
                                </td>
                                <td>
                                    <p class="m-0 text-center">{{ $exp->date }}</p>
                                </td>
                                <td>
                                    <p class="m-0 text-center">{{ $exp->expiration_date }}</p>
                                </td>
                                <td>
                                    <p>
                                        <a class="btn-republish" data-link="{{ route('offer.republish', $exp->slug) }}"
                                           href="#">
                                            <i class="text-success fas fa-history"></i>
                                        </a>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <a href="{{ route('offer.candidates', $exp->slug) }}">
                                            <i class="fas fa-briefcase"></i>
                                        </a>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <a href="{{ route('offer.detail', $exp->slug) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </p>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-12">
                                            <form method="post" action="{{ route('offer.delete', $exp->slug) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-sm btn btn-danger" type="submit">Eliminar</button>
                                            </form>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row justify-content-center">
                {{ $expired->links() }}
            </div>

        @endif

    </div>
    <script>
        jQuery(document).ready(function (a) {
            a('.featured').change(function (e) {
                let container = a(this).parent('div');
                let adId = container.find('[name="id"]').val();
                let _token = a("[name='_token']").val();
                let action = e.currentTarget.checked;
                a.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': _token
                    },
                });
                a.ajax({
                    type: 'post',
                    url: "{{route('offer.featured')}}",
                    data: {
                        id: adId,
                        feature: action
                    },
                    success: function (json) {
                        if (json.code == 200) {
                            window.location.reload();
                        }
                    },
                    error: function (json) {
                        a('.featured').prop('checked', false);
                        window.location.reload();
                    }
                })
            })
        })
    </script>

@endsection


@push('scripts')
    <script>
        jQuery(document).ready(function ($) {
            $('[data-toggle="popover"]').popover();

            $('.btn-republish').click(function (e) {
                e.preventDefault();
                var url = $(this).data('link');
                $('#republishOffer').modal('show');
                $('#republish-link').attr('action', url);
            })
        });
    </script>
@endpush


