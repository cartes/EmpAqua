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
            <div class="h3 my-0">Detalle de Ofertas</div>
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
                        <div class="h4">Resultados para: {{$search}}</div>
                    </div>
                </div>
            @endisset
            <div class="row">
                <div id="container-offer-display" class="col-12 col-lg-8 order-lg-2 px-0">
                    <div class="container py-md-4">
                        <div class="offer-header">
                            @if (session()->get('id'))
                                <a id="post-add-fav" class="offer-header__fav" href="#" data-favorite="{{$favorite ? "true" : "false"}}" title="Guardar en favoritos">
                                    <i class="{{$favorite ? 'fas' : 'far'}} fa-bookmark"></i>
                                </a>
                            @endif
                            <div class="offer-header__logo d-none d-sm-flex">
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
                                    <small class="mt-2 d-block text-muted">{{ $offer->publication }}</small>
                                @endif
                            </div>
                            <div class="offer-header__main">
                                @if(!is_null($offer))
                                    <h1 class="container-offer-title font-weight-bold">{{ $offer->title }}</h1>
                                @endif

                                @if (is_object($offer->businessMeta))
                                    <p id="container-business-name" class="offer-header__company">
                                        @if ($offer->confidential)
                                            <strong>Confidencial</strong>
                                        @else
                                            <strong>{{$offer->businessMeta->business_name}}</strong>
                                        @endif
                                        <small class="container-offer-title-created-at">{{ $offer->created_at->format('d \\d\\e F \\d\\e Y') }}</small>
                                    </p>
                                @endif

                                @isset($offer->category)
                                    <span class="offer-header__category">{{ $offer->category->title }}</span>
                                @endisset

                                @if(session()->get('role') != 'business')
                                    <div class="offer-header__actions">
                                        @if ($postuled && !$favorite)
                                            <span class="offer-header__applied"><i class="fas fa-check-circle"></i> Ya postulaste a esta oferta</span>
                                        @elseif(session()->get('id'))
                                            <a data-toggle="modal" data-target="#postuleModal" href="#" class="btn btn-primary">Postula
                                                Acá</a>
                                        @else
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#loginUserModal">Inicie
                                                sesión para postular</a>
                                        @endif
                                        <div id="social-container">
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

                        <div class="offer-points">
                            <h2 class="offer-points__heading d-block d-sm-none">Puntos principales</h2>
                            {{-- Comuna --}}
                            @if($offer->businessMeta->comune != '')
                                <div class="offer-points__item">
                                    <i class="fas fa-map-marker-alt"></i><span>{{$offer->businessMeta->comune}}</span>
                                </div>
                            @endif
                            {{-- Horario --}}
                            <div class="offer-points__item">
                                <i class="far fa-building"></i><span>{{$offer->position}}</span>
                            </div>
                            <div class="offer-points__item">
                                <i class="fas fa-dollar-sign"></i><span>{{$offer->salary}}</span>
                            </div>
                            <div class="offer-points__item">
                                <i class="fas fa-file-contract"></i><span>{{$offer->experience}}</span>
                            </div>
                            @if($offer->vacancy > 0)
                            <div class="offer-points__item">
                                <i class="fas fa-user"></i><span>Vacantes: {{ $offer->vacancy }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="row points-offer px-0 mx-0">

                            <div class="col-12 d-block d-sm-none">
                                <div class="points-offer__label h4">Detalles de la oferta</div>
                            </div>
                            @if (filled(trim(strip_tags(html_entity_decode((string) $offer->description)))))
                            <div class="col-12 mt-2">
                                <h2 class="h3 mb-3">Funciones del Cargo</h2>

                                <div id="container-offer-description">{!! preg_replace("/[\w-]+@([\w-]+\.)+[\w-]+/", "[Email Bloqueado]", \App\Helpers\Helper::cleanHtml($offer->description)); !!}</div>
                            </div>
                            @endif
                            @if (filled(trim((string) $offer->requirements)))
                            <div class="col-12">
                                <h2 class="h3 mb-3">Requerimientos del cargo</h2>

                                <div id="container-offer-requirements">{{ $offer->requirements }}</div>
                            </div>
                            @endif

                            @if ( collect($offer->benefits)->isNotEmpty() )
                                <div class="col-12">
                                    <h2 class="h3 mb-3">Beneficios</h2>

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
                <aside class="col-md-4 d-none d-lg-block order-lg-1">
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
                                                <div class="card-title h5 text-capitalize text-left m-0 p-0">
                                                    {{$off->title}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="col-12 col-sm-8">
                                    @if ($off->businessMeta)
                                        @if(!$off->confidential)
                                            <div class="h6">
                                                <strong>{{$off->businessMeta->business_name}}</strong>
                                                @if ($off->is_new)
                                                -
                                                    <span class="text-danger text-uppercase">
                                                        {{'Nuevo'}}
                                                    </span>
                                                @endif
                                                {{ $off->publication }}
                                            </div>
                                        @else
                                            <div class="h6">
                                                <strong>Confidencial</strong> -
                                                @if ($off->is_new)
                                                    <span class="text-danger text-uppercase">
                                                        {{'Nuevo'}}
                                                    </span>
                                                @endif
                                                {{ $off->publication }}
                                            </div>
                                        @endif
                                        @if ( $off->featured )
                                            <div class="h6 d-inline-flex">
                                                <span class="text-primary text-uppercase">
                                                    {{'Destacada'}}
                                                </span>
                                            </div>
                                        @endif

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
@push('scripts')
    <script>
        jQuery(document).ready(function () {
            var panel = document.getElementById('container-offer-display');
            if (!panel) return;
            var update = function () {
                var top = Math.min(130, window.innerHeight - panel.offsetHeight - 16);
                panel.style.top = top + 'px';
            };
            update();
            window.addEventListener('resize', update);
            if (window.ResizeObserver) { new ResizeObserver(update).observe(panel); }
        });
    </script>
@endpush
@push("styles")
    <style>
        #container-offer-display .container { max-width: 100%; }
        /* Detalle: scrollea con la página y se fija al llegar a su final (el top se calcula en JS según su alto) */
        @media (min-width: 992px) {
            #container-offer-display { position: sticky; top: 130px; align-self: flex-start; }
        }
        .offer-header { position: relative; display: flex; gap: 1.5rem; align-items: flex-start; background: #fff; border-radius: 15px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
        .offer-header__fav { position: absolute; top: .9rem; right: 1.1rem; color: #6B6B6B; font-size: 1.5rem; line-height: 1; }
        .offer-header__logo { flex: 0 0 150px; flex-direction: column; align-items: center; text-align: center; padding-right: 1.5rem; border-right: 1px solid #eef1f4; }
        .offer-header__main { flex: 1 1 auto; min-width: 0; padding-right: 2rem; }
        .offer-header__main .container-offer-title { margin: 0 0 .5rem; font-size: 1.4rem; line-height: 1.3; }
        .offer-header__company { margin: 0 0 .75rem; color: #374151; }
        .offer-header__company small { display: block; color: #6b7280; margin-top: .15rem; }
        .offer-header__category { display: inline-block; background: #e8f1fb; color: #1f4690; font-size: .85rem; font-weight: 700; padding: .25rem .8rem; border-radius: 1rem; margin: 0 0 1rem; }
        .offer-header__actions { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
        #container-offer-display .offer-header__actions .btn.btn-primary { width: auto; min-width: 190px; height: auto; padding: .45rem 1.5rem; background-color: #F08F01 !important; color: #fff !important; border: 2px solid #fff; border-radius: 20px; box-shadow: 0 4px 4px rgba(0,0,0,.25); }
        .offer-header__applied { display: inline-flex; align-items: center; gap: .5rem; background: #e8f6ee; color: #1e7e46; font-weight: 600; padding: .45rem 1rem; border-radius: 1.5rem; }
        .offer-header__applied i { color: #1e7e46; }
        .offer-header #social-container { position: relative; flex: 0 0 auto; }
        .offer-points { display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: .75rem; margin: 1rem 0; padding: 1rem; background: #fff; border-radius: 15px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
        .offer-points__heading { grid-column: 1 / -1; margin: 0; font-size: .9rem; font-weight: 700; color: #F08F01; }
        .offer-points__item { display: flex; align-items: center; gap: .6rem; background: #f8fafc; border-radius: .6rem; padding: .6rem .8rem; color: #6B6B6B; font-size: .9rem; }
        .offer-points__item i { color: #F08F01; font-size: 1.1rem; width: 1.25rem; text-align: center; }
        /* El tema fuerza background transparente en .container *, así que los "chips" no llevan fondo ni padding lateral: todo parte del mismo borde izquierdo */
        #container-offer-display .offer-header__main > * { margin-left: 0 !important; padding-left: 0 !important; text-indent: 0; }
        #container-offer-display .offer-header__main .container-offer-title { margin: 0 0 .5rem !important; padding: 0 !important; line-height: 1.3 !important; }
        #container-offer-display .offer-header__company { margin: 0 0 .5rem !important; padding: 0 !important; line-height: 1.35 !important; }
        #container-offer-display .offer-header__company strong,
        #container-offer-display .offer-header__company small { display: block; margin: 0 !important; padding: 0 !important; line-height: 1.35 !important; }
        #container-offer-display .offer-header__category { display: block; margin: 0 0 .75rem !important; padding: 0 !important; line-height: 1.35 !important; border-radius: 0; }
        #container-offer-display .offer-header__actions { margin: 0 !important; padding: 0 !important; }
        #container-offer-display .offer-header__applied { padding: 0 !important; line-height: 1.35 !important; border-radius: 0; }
        @media (max-width: 575.98px) {
            .offer-header { flex-direction: column; gap: 0; padding: 1.1rem; }
            .offer-header__main { width: 100%; padding-right: 1.75rem; }
            .offer-header__actions { flex-direction: column; align-items: flex-start; gap: .75rem; }
            .offer-header__actions .btn.btn-primary { width: 100%; }
        }
    </style>
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
