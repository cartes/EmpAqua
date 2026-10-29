<div class="container social-share position-relative d-block d-sm-none">
    <div class="row m-0">
        <div class="col-8 py-4">
            <span class="text-left">
                <a href="{{route('offer.list')}}">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </span>
        </div>
        <div id="social-container-mobile" class="col-2 text-center py-3">
            <ul class="social-share">
                <li class="position-relative">
                    <a class="btn btn-share">
                        <i class="fas fa-share-alt"></i>
                    </a>
                    <div class="sub-menu position-absolute">
                        <ul>
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ route('offer.show', [ 'slug' => $offer->slug])}}" class="social-button" target="_blank"><span class="fab fa-facebook-square"></span></a></li>
                            <li><a href="https://twitter.com/intent/tweet?text=Quiero&nbsp;compartir&nbsp;esta&nbsp;oferta&amp;url={{ route('offer.show', [ 'slug' => $offer->slug]) }}" class="social-button " target="_blank" id=""><span class="fab fa-twitter"></span></a></li>
                            <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ route('offer.show', [ 'slug' => $offer->slug]) }}&amp;title={{ $offer->title }}&amp;summary=dit is de linkedin summary" target="_blank" class="social-button " id=""><span class="fab fa-linkedin"></span></a></li>
                            <li><a href="https://wa.me/?text={{ route('offer.show', [ 'slug' => $offer->slug]) }}" class="social-button " id="" target="_blank"><span class="fab fa-whatsapp"></span></a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col-2 text-center py-4">
            @if(session()->get('id'))
            <a id="post-add-fav-mob" class="w-100"  href="#" data-favorite="{{$favorite ? "true" : "false"}}">

                <span>
                    <i class="{{$favorite ? 'fas' : 'far'}} fa-bookmark"></i>
                </span>
            </a>
            @endif
        </div>
    </div>
</div>
<div class="container d-none d-sm-block">
    <div class="row">
        <div class="col-12 my-4">
            <h3>Detalle de Ofertas</h3>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center position-relative my-3">
        <div class="container-fluid p-0">
            <!-- /18588809/EASKHDS -->
            <div class="container position-relative">
                <div class="d-none d-sm-block container skyscrapper container-left superior position-absolute" style="left: 101%; z-index: 300;">
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
                <div class="d-none d-sm-block container skyscrapper container-left inferior position-absolute" style="left: 101%">
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
                <div class="d-none d-sm-block container skyscrapper container-right superior position-absolute" style="left: -18%; z-index: 300;">
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
                <div class="d-none d-sm-block container skyscrapper container-right inferior position-absolute" style="left: -18%">
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
        </div>

        <div class="col-12">
            @isset($search)
                <div class="row">
                    <div class="col-md-10">
                        <h4>Resultados para: {{$search}}</h4>
                    </div>
                </div>
            @endisset
            <div class="row">
                <aside class="col-md-4 d-none d-lg-block">
                    @if (!isset($search))
                        @php($search = '')
                    @endif

                    @forelse($offers as $off)
                        <div class="card container-offer mb-1{{ $off->featured  ? ' back-orange' : '' }}">
                            <div class="card-body">
                                <a href="{{ route("offer.show", ['slug' => $off->slug, 'search' => $search, 'featured' => $featured]) }}">
                                    <div class="py-2 px-3">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <h5 class="card-title text-capitalize text-left m-0 p-0">
                                                    {{$off->title}}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="col-12 col-sm-8">
                                    @if ($off->businessMeta)
                                        @if(!$off->confidential)
                                            <h6>
                                                <strong>{{$off->businessMeta->business_name}}</strong>
                                                @if ($off->is_new)
                                                -
                                                    <span class="text-danger text-uppercase">
                                                        {{'Nuevo'}}
                                                    </span>
                                                @endif
                                                {{ $off->publication }}
                                            </h6>
                                        @else
                                            <h6>
                                                <strong>Confidencial</strong> -
                                                @if ($off->is_new)
                                                    <span class="text-danger text-uppercase">
                                                        {{'Nuevo'}}
                                                    </span>
                                                @endif
                                                {{ $off->publication }}
                                            </h6>
                                        @endif
                                        <h6 class="d-inline-flex">
                                            @if ( $off->featured )
                                                <span class="text-primary text-uppercase">
                                                    {{'Destacada'}}
                                                </span>
                                            @endif
                                        </h6>

                                    @endif

                                </div>
                                <div class="py-2 px-3">
                                    <p class="p-0 m-0">
                                        {{\Illuminate\Support\Str::limit(strip_tags(html_entity_decode($off->description)), 50)}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card">
                            <div class="card-body">
                                <p>No hay ofertas de trabajo para mostrar!</p>
                            </div>
                        </div>
                    @endforelse
                </aside>
                <div id="container-offer-display" class="col-12 col-lg-8 px-0">
                    <div class="container py-md-4">
                        <div class="row header-offer">
                            @if (session()->get('id'))
                                <div class="col-12 position-relative">
                                    <a id="post-add-fav" class="d-none d-sm-block" href="#" data-favorite="{{$favorite ? "true" : "false"}}">
                                        <i class="{{$favorite ? 'fas' : 'far'}} fa-bookmark"></i>
                                    </a>
                                </div>
                            @endif
                            <div class="col-4 d-none d-sm-block">
                                @if ($offer->businessMeta)
                                    @if(!$offer->confidential)
                                        <img class="w-100 h-auto" src="{{ $offer->businessMeta->pathAttachment() }}"
                                             alt="{{ $offer->businessMeta->business_name }}"
                                        />
                                    @else
                                        <img class="w-100 h-auto" src="https://www.empleosaqua.cl/images/1x/logo-empleos-aqua.png"
                                             width="170" alt="Loogo Empleos Aqua"
                                        />
                                    @endif
                                    <small class="mt-1 d-block text-white">{{ $offer->publication }}</small>
                                @endif
                            </div>
                            <div class="col-12 col-sm-8">
                                @if(!is_null($offer))
                                    <h2 class="container-offer-title font-weight-bold"><strong>{{ $offer->title }}</strong></h2>
                                @endif

                                @if (is_object($offer->businessMeta))

                                    <p id="container-business-name" class="m-0 p-0">
                                        @if ($offer->confidential)
                                            <strong>Confidencial</strong>
                                            <small
                                                    class="container-offer-title-created-at">{{ $offer->created_at->format('d \\d\\e F \\d\\e Y') }}</small>
                                        @else
                                            <strong>{{$offer->businessMeta->business_name}}</strong><small
                                                    class="container-offer-title-created-at">{{ $offer->created_at->format('d \\d\\e F \\d\\e Y') }}</small>
                                        @endif

                                    </p>
                                @endif

                                @isset($offer->category)
                                    <h3 class="category-title">{{ $offer->category->title }}</h3>
                                @endisset
                                @if(session()->get('role') != 'business')
                                    <div class="row position-relative">
                                        @if ($postuled && !$favorite)
                                            <div class="col-8 text-end">
                                                <p>Ya postulaste a esta oferta</p>
                                            </div>
                                        @elseif(session()->get('id'))
                                            <div class="col-8">
                                                <a data-toggle="modal" data-target="#postuleModal" href="#" class="w-100 btn btn-primary">Postula
                                                    Acá</a>
                                            </div>
                                        @else
                                            <div class="ms-auto col-8">
                                                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#loginUserModal">Inicie
                                                    sesión para postular</a>
                                            </div>
                                        @endif
                                        <div class="col-4 justify-content-start" id="social-container">
                                            <ul class="social-share">
                                                <li class="position-relative">
                                                    <a class="btn btn-share">
                                                        <i class="fas fa-share-alt"></i>
                                                    </a>
                                                    <div class="sub-menu position-absolute">
                                                        <ul>
                                                            <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ route('offer.show', [ 'slug' => $offer->slug]) }}" class="social-button" target="_blank"><span class="fab fa-facebook-square"></span></a></li>
                                                            <li><a href="https://twitter.com/intent/tweet?text=Quiero&nbsp;compartir&nbsp;esta&nbsp;oferta&amp;url={{ route('offer.show', [ 'slug' => $offer->slug]) }}" class="social-button " target="_blank" id=""><span class="fab fa-twitter"></span></a></li>
                                                            <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ route('offer.show', [ 'slug' => $offer->slug]) }}&amp;title={{ $offer->title }}&amp;summary=dit is de linkedin summary" target="_blank" class="social-button " id=""><span class="fab fa-linkedin"></span></a></li>
                                                            <li><a href="https://wa.me/?text={{ route('offer.show', [ 'slug' => $offer->slug]) }}" class="social-button " id="" target="_blank"><span class="fab fa-whatsapp"></span></a></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @elseif (session()->get('id') == $offer->id_business)
                                    <a class="btn btn-primary" href="{{ route('offer.detail', ['offer' => $offer->slug]) }}">
                                        Edite su Oferta
                                    </a>
                                @endif
                            </div>

                        </div>

                        <div class="row points-offer d-flex justify-content-between">
                            <div class="col-12 d-block d-sm-none">
                                <h4>Puntos principales</h4>
                            </div>
                            {{-- Comuna --}}
                            @if($offer->businessMeta->comune != '')
                                <div class="col-12 col-sm-auto small">
                                    <i class="fas fa-map-marker-alt"></i><span>{{$offer->businessMeta->comune}}</span>
                                </div>
                            @endif
                            {{-- Horario --}}
                            <div class="col-12 col-sm-auto small">
                                <i class="far fa-building"></i><span>{{$offer->position}}</span>
                            </div>
                            <div class="col-12 col-sm-auto small">
                                <i class="fas fa-dollar-sign"></i><span>{{$offer->salary}}</span>
                            </div>
                            <div class="col-12 col-sm-auto small">
                                <i class="fas fa-file-contract"></i><span>{{$offer->experience}}</span>
                            </div>
                            @if($offer->vacancy > 0)
                            <div class="col-12 col-sm-auto small">
                                <i class="fas fa-user"></i><span>Vacantes: {{ $offer->vacancy }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="row points-offer px-0 mx-0">

                            <div class="col-12 d-block d-sm-none">
                                <h4>Detalles  de la oferta</h4>
                            </div>
                            <div class="col-12 mt-2">
                                <h3 class="mb-3">Funciones del Cargo</h3>

                                <div id="container-offer-description">{!! preg_replace("/[\w-]+@([\w-]+\.)+[\w-]+/", "[Email Bloqueado]", \App\Helpers\Helper::cleanHtml($offer->description)); !!}</div>
                            </div>
                            <div class="col-12">
                                <h3 class="mb-3">Requerimientos del cargo</h3>

                                <div id="container-offer-requirements">{{ $offer->requirements }}</div>
                            </div>

                            @if ( $offer->benefits )
                                <div class="col-12">
                                    <h3 class="mb-3">Beneficios</h3>

                                    <div id="container-offer-benefits">
                                        @foreach( $offer->benefits as $benefit )
                                            <div class='btn-benefit mr-3 mb-2 btn btn-secondary text-uppercase'>{!! preg_replace("/[\w-]+@([\w-]+\.)+[\w-]+/", "[Email Bloqueado]", e($benefit->benefit)); !!}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-none d-sm-block mt-3 justify-content-center">
                {{ $offers->links('partials.pagination') }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        jQuery(document).ready( function($) {
            // Boton de favoritos id post-add-fav, peticion via ajax para agregar o quitar favorito

            $('#post-add-fav, #post-add-fav-mob').click(function(e) {
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
                                $('#post-add-fav').data('favorite', 'true');
                                $('#post-add-fav i').removeClass('far').addClass('fas');
                                $('#post-add-fav-mob').data('favorite', 'true');
                                $('#post-add-fav-mob i').removeClass('far').addClass('fas');
                            } else if(data.isFavorite == '0' || data.fav == '1') {
                                $('#post-add-fav').data('favorite', 'false');
                                $('#post-add-fav i').removeClass('fas').addClass('far');
                                $('#post-add-fav-mob').data('favorite', 'false');
                                $('#post-add-fav-mob i').removeClass('fas').addClass('far');
                            }
                        }
                    }
                });
            });

            $('.btn-share').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var wind = $this.parent().find('.sub-menu');
                console.log(wind);
                if ($this.hasClass('open')) {
                    wind.slideUp("fast", function () {
                        $this.removeClass('open');
                    });
                } else {
                    wind.slideDown("slow", function () {
                        $this.addClass('open');
                    })
                }
            })
        })
    </script>
    <script>
        jQuery(document).ready(function (a) {
            var faded = false;
            a(window).scroll(function fix_element() {
                let position = a(window).scrollTop();
                let container = a('.skyscrapper.superior').find('div');
                let cuerpo = a('body');
                let halfBody = parseInt(cuerpo.height() / 2) + 600;

                if (position > 80) {
                    a('.skyscrapper').find('div').css({
                        'position': 'fixed',
                        'top': '120px'
                    });
                } else {
                    a('.skyscrapper').find('div').css({
                        'position': 'absolute',
                        'top': 'auto',
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
