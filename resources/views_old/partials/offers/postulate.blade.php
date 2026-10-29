<div class="container">
    <div class="row justify-content-center my-3">
        @isset($search)
            <div class="col-md-10">
                <h4>Resultados para: {{$search}}</h4>
            </div>
        @endisset
        <div class="col-md-3 pr-md-0 mr-md-0 d-none d-md-block">
            @if (!isset($search))
                @php($search = '')
            @endif

            @forelse($offers as $off)
                <div class="container-offer mb-1{{ $off->featured  ? ' back-orange' : '' }}">
                    <a href="{{ route("offer.show", ['slug' => $off->slug, 'search' => $search, 'featured' => $featured]) }}">
                        <div class="py-2 px-3">
                            <div class="row">
                                <div class="col-md-9">
                                    <h5 class="text-capitalize text-left m-0 p-0">
                                        {{$off->title}}
                                        @if ($off->is_new)
                                            <span class="badge bg-success">
                                            {{'Nuevo'}}
                                        </span>
                                        @endif
                                        @if ( $off->featured )
                                            <span class="badge bg-success" style="background-color: #d88f32;">
                                            {{'Destacada'}}
                                        </span>
                                        @endif

                                    </h5>
                                </div>
                            </div>
                            @if(!is_null($off->businessMeta))
                                <div class="row">
                                    @if ( !$off->confidential)
                                    <div class="col-12">
                                        <h6>{{$off->businessMeta->business_name}}</h6>
                                    </div>
                                    @endif

                                    <div class="col-12">
                                        @if($off->businessMeta->comune != '')
                                            <h6>{{$off->businessMeta->comune}}</h6>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="py-2 px-3">
                            <p class="p-0 m-0">
                                {{\Illuminate\Support\Str::limit(strip_tags(html_entity_decode($off->description)), 50)}}
                            </p>
                        </div>
                    </a>
                </div>
            @empty
                <div class="card">
                    <div class="card-body">
                        <p>No hay ofertas de trabajo para mostrar!</p>
                    </div>
                </div>
            @endforelse
        </div>
        <div id="container-offer-display" class="col-md-6 pl-0">
            <div class="row p-3 px-2">
                @if(!is_null($offer))
                    <div class="col-12">
                        <div class="breadcrumb d-none d-sm-block px-0">
                            <ul class="breadcrumb-container">
                                <li class="breadcrumb-item">
                                    <a href="{{route('/')}}">
                                        Home
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{route('offer.list')}}">
                                        Ofertas
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    {{$offer->title}}
                                </li>
                            </ul>
                        </div>


                        <small
                            id="container-offer-title-created-at">{{ $offer->created_at->format('d \\d\\e F \\d\\e Y') }}</small>
                        <h3 class="category-title">{{ $offer->category->title }}</h3>
                    </div>
                    <div class="col-12">
                        <h2 id="container-offer-title font-weight-bold"><strong style="color: #d88f32">{{ $offer->title }}</strong></h2>

                    </div>
                @endif

                    <div class="col-12">
                        <div id="social-links">
                        	<ul>
                        		<li><a href="https://www.facebook.com/sharer/sharer.php?u={{ route('offer.show', [ 'slug' => $offer->slug]) }}" class="social-button" target="_blank"><span class="fab fa-facebook-square"></span></a></li>
                        		<li><a href="https://twitter.com/intent/tweet?text=my share text&amp;url={{ route('offer.show', [ 'slug' => $offer->slug]) }}" class="social-button " target="_blank" id=""><span class="fab fa-twitter"></span></a></li>
                        		<li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ route('offer.show', [ 'slug' => $offer->slug]) }}&amp;title={{ $offer->title }}&amp;summary=dit is de linkedin summary" target="_blank" class="social-button " id=""><span class="fab fa-linkedin"></span></a></li>
                        		<li><a href="https://wa.me/?text={{ route('offer.show', [ 'slug' => $offer->slug]) }}" class="social-button " id="" target="_blank"><span class="fab fa-whatsapp"></span></a></li>    
                        	</ul>
                        </div>
                    </div>

                @if (is_object($offer->businessMeta))

                    <div class="col-12">

                        <p id="container-business-name" class="m-0 p-0">
                            @if ($offer->confidential)
                            <strong>Destacada empresa</strong>
                            @else
                            <strong>{{$offer->businessMeta->business_name}}</strong>
                            @endif

                        </p>
                        <p id="container-business-comune"
                           class="m-0 p-0 mb-5" style="color: #999;">
                            {{$offer->businessMeta->comune}}
                        </p>
                    </div>
                @endif

                <div class="col-12 mt-2">
                    <h3 class="mb-3" style="font-size: 1.25rem; border-bottom: 1px solid #d88f32;display: inline-block; padding-right: 20px;">Funciones del Cargo</h3>

                    <div id="container-offer-description">{!! preg_replace("/[\w-]+@([\w-]+\.)+[\w-]+/", "[Email Bloqueado]", $offer->description); !!}</div>
                </div>
                <div class="col-12">
                    <h3 class="mb-3" style="font-size: 1.25rem; border-bottom: 1px solid #d88f32;display: inline-block; padding-right: 20px;">Requerimientos del cargo</h3>

                    <div id="container-offer-requirements">{{ $offer->requirements }}</div>
                </div>

                <!-- Datos de la oferta -->
                <div class="col-12">
                    <h3 class="mb-3" style="font-size: 1.25rem; border-bottom: 1px solid #d88f32;display: inline-block; padding-right: 20px;">Datos de la oferta</h3>
                    <div>
                        <strong>SALARIO:</strong><br>
                        {{$offer->salary}}
                    </div>
                    <!-- {{$offer->position}} -->
                    <div style="margin-top: 20px">
                        <strong>JORNADA LABORAL:</strong><br>
                        {{$offer->position}}
                    </div>
                    <div style="margin-top: 20px">
                        <strong>TIPO DE CONTRATO:</strong><br>
                        {{$offer->experience}}
                    </div>
                </div>


                @if ( $offer->benefits )
                    <div class="col-12">
                        <h3 class="mb-3" style="font-size: 1.25rem; border-bottom: 1px solid #d88f32;display: inline-block; padding-right: 20px;">Beneficios</h3>

                        <div id="container-offer-benefits">
                            @foreach( $offer->benefits as $benefit )
                                <div class='btn-benefit mr-3 mb-2 btn btn-secondary'>{!! preg_replace("/[\w-]+@([\w-]+\.)+[\w-]+/", "[Email Bloqueado]", $benefit->benefit); !!}</div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="col-12 text-end justify-content-end mt-md-5">
                    @if(session()->get('role') != 'business')
                        <div class="row">
                            @if ($postuled && !$favorite)
                                <div class="col-12 text-end">
                                    <p>Ya postulaste a esta oferta</p>
                                </div>
                            @elseif(session()->get('id'))
                                <div class="col-5">
                                    <a class="text-light w-100 btn {{$favorite ? 'btn-success' : 'btn-secondary'}}" id="post-add-fav" href="#" data-favorite="{{$favorite ? "true" : "false"}}">Favoritos <i class="{{$favorite ? 'fa-solid' : 'fa-regular'}} fa-heart"></i></a>
                                </div>
                                <div class="col-5">
                                    <a data-toggle="modal" data-target="#postuleModal" href="#" class="w-100 btn btn-primary">Postula
                                        Acá</a>
                                </div>
                            @else
                                <div class="ms-auto col-5">
                                    <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#loginUserModal">Inicie
                                        sesión para postular</a>
                                </div>
                            @endif
                        </div>
                    @elseif (session()->get('id') == $offer->id_business)
                        <a class="btn btn-primary" href="{{ route('offer.detail', ['offer' => $offer->slug]) }}">
                            Edite su Oferta
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div id="container-meta-business" class="col-md-2 col-12">
            @if (!$offer->confidential)
    
            <div class="card" style="width: 100%;">
                @if($offer->businessMeta->logo)
                <img src="{{ $offer->businessMeta->logo }}" class="card-img-top" alt="...">
                @endif
                <div class="card-body bg-light border border-2">
                    <h5 class="card-title">{{ $offer->businessMeta->business_name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{$offer->businessMeta->comune}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">{{$offer->businessMeta->city}}</h6>
                    <p class="card-text">{{$offers[0]->businessMeta->activity}}</p>
                </div>
    
            @endif

        </div>
    </div>
    <div class="row mt-4 justify-content-center">
        {{ $offers->links() }}
    </div>
</div>

@push('scripts')
    <script>
        jQuery(document).ready( function($) {
            // Boton de favoritos id post-add-fav, peticion via ajax para agregar o quitar favorito

            $('#post-add-fav').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('offer.favorite') }}',
                    type: 'POST',
                    data: {
                        id_offer: '{{ $offer->slug }}',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.code == 200) {
                            if (data.isFavorite == '4') {
                                $('#post-add-fav').removeClass('btn-secondary').addClass('btn-success');
                                $('#post-add-fav').data('favorite', 'true');
                                $('#post-add-fav i').removeClass('fa-regular').addClass('fa-solid');
                            } else if(data.isFavorite == '0' || data.fav == '1') {
                                $('#post-add-fav').removeClass('btn-success').addClass('btn-secondary');
                                $('#post-add-fav').data('favorite', 'false');
                                $('#post-add-fav i').removeClass('fa-solid').addClass('fa-regular');
                            }
                        }
                    }
                });
            });
        })
    </script>
@endpush
@push("styles")
<style>
    #social-links ul {
        padding-left: 0;
    }

    #social-links li {
        list-style: none;
        display: inline-block;
        margin-right: 10px;
    }

    #social-links li a {
        font-size: 1.5rem;
    }
</style>
@endpush