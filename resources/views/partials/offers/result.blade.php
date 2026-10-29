<div class="container-fluid container-results py-3">
    <div class="row">
        <div class="col-12 d-none d-md-block text-center">
            <!-- /18588809/EAHA1_N -->
            <div id='div-gpt-ad-1666795994590-0' style='min-width: 940px; min-height: 90px;'>
                <script>
                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1666795994590-0'); });
                </script>
            </div>
        </div>
    </div>

    <div class="container">

        <div class="row justify-content-center my-3">
            @if(!empty($search))
                <div class="col-10 col-sm-12">
                    <h1 class="h3 mb-0">Resultados para: {{ $search }}</h1>
                </div>
            @elseif(!empty($featured))
                <div class="col-10 col-sm-12">
                    <h1 class="h3 mb-0">Ofertas destacadas</h1>
                </div>
            @else
                <div class="col-10 col-sm-12">
                    <h1 class="h3 mb-0">Todas las ofertas</h1>
                </div>
            @endif
            <div class="col-2 d-block d-sm-none">
                <i class="fas fa-filter"></i>
            </div>
        </div>
        <div class="row justify-content-center position-relative my-3">
            <div class="container-fluid p-0">
                <!-- /18588809/EASKHDS -->
                <div class="container position-relative d-none d-md-block">
                    <div class="container skyscrapper container-left superior position-absolute" style="left: 101%">
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
    
                <div class="container position-relative d-none d-md-block">
                    <div class="container skyscrapper container-left inferior position-absolute" style="left: 101%">
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
    
                <div class="container position-relative d-none d-md-block">
                    <div class="container skyscrapper container-right superior position-absolute" style="left: -18%">
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
    
                <div class="container position-relative d-none d-md-block">
                    <div class="container skyscrapper container-right inferior position-absolute" style="left: -18%">
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
                @if (!isset($search))
                    @php($search = '')
                @endif
                @php( $i = 0)
                @forelse($offers as $offer)
                    @if ($featured)
                        @php ($array = ['slug' => $offer->slug, 'search' => $search, 'featured' => true])
                    @else
                        @php ($array = ['slug' => $offer->slug, 'search' => $search, 'featured' => false])
                    @endif

                    <div class="card offer-card mb-3{{ $offer->featured ? ' back-orange offer-card--featured' : '' }}">
                        <div class="card-body">
                            <div class="offer-card__header">
                                <h2 class="offer-card__title card-title py-0 m-0">
                                    <a href="{{ route("offer.show", $offer->slug) }}">{{ $offer->title }}@if($offer->handicapped)  &nbsp;<i class="fas fa-wheelchair"></i>  @endif</a>
                                </h2>
                                <div class="offer-card__actions">
                                    @if ($offer->featured)
                                        <span class="badge offer-card__badge">Destacada</span>
                                    @endif
                                    @if (session()->get('id'))
                                        @isset($offer->candidates)
                                            @php($textStatus = '')
                                            @foreach($offer->candidates as $candidate)
                                                @if (session()->get('id') == $candidate->id_user)
                                                    @php($textStatus = $candidate->status['text'])
                                                    @break
                                                @endif
                                            @endforeach
                                            @if ($textStatus == 'favorite')
                                            <a class="post-add-fav offer-card__fav" href="#" data-favorite="true" data-slug="{{$offer->slug}}" title="Quitar de favoritos">
                                                <i class="fas fa-bookmark"></i>
                                            </a>
                                            @else
                                            <a class="post-add-fav offer-card__fav" href="#" data-favorite="false" data-slug="{{$offer->slug}}" title="Guardar en favoritos">
                                                <i class="far fa-bookmark"></i>
                                            </a>
                                            @endif
                                        @endisset
                                    @endif
                                </div>
                            </div>

                            @if ($offer->businessMeta)
                                <div class="offer-card__company">
                                    @if(!$offer->confidential)
                                        <strong>{{$offer->businessMeta->business_name}}</strong>
                                    @else
                                        <strong>Confidencial</strong>
                                    @endif
                                    <span class="offer-card__date">- {{ $offer->publication }}</span>
                                </div>

                                <div class="offer-card__meta">
                                    <span class="offer-card__chip"><i class="fas fa-map-marker-alt"></i>
                                        <span class="text-capitalize">{{ $offer->businessMeta->comune }}</span></span>
                                    <span class="offer-card__chip"><i class="far fa-building"></i>
                                        <span class="text-capitalize">{{ $offer->position }}</span></span>
                                </div>

                                <p class="offer-card__desc">
                                    {{\Illuminate\Support\Str::limit(strip_tags(html_entity_decode($offer->description)), 150)}}
                                </p>
                            @endif
                        </div>
                    </div>


                    @if ($i == 5 )
                        <div class = "banner-result-aside my-1">
                            <!-- /18588809/EACIZ_N -->
                            <div id='div-gpt-ad-1633611877658-0' style='min-width: 330px; min-height: 100px;'>
                                <script>
                                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1633611877658-0'); });
                                </script>
                            </div>
                        </div>
                    @endif
                    @php($i++)
                @empty
                    <div class="card">
                        <div class="card-body">
                            <p>No hay ofertas de trabajo para mostrar!</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="row d-block d-sm-block justify-content-center">
            {{ $offers->links('partials.pagination') }}
        </div>
    </div>
</div>
</div>

@push('scripts')
    @if (!is_null($offers[0]))
        <script>
            window.googletag = window.googletag || {cmd: []};
            googletag.cmd.push(function() {
                googletag.defineSlot('/18588809/EACIZ_N', [330, 100], 'div-gpt-ad-1633611877658-0').addService(googletag.pubads());
                googletag.pubads().enableSingleRequest();
                googletag.enableServices();
            });
            jQuery(document).ready( function($) {
                // Boton de favoritos id post-add-fav, peticion via ajax para agregar o quitar favorito

                $('.post-add-fav').click(function(e) {
                    var $this = $(this);
                    var slug = $this.data('slug');
                    e.preventDefault();
                    $.ajax({
                        url: '{{ route('offer.favorite') }}',
                        type: 'POST',
                        data: {
                            id_offer: slug,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.code == 200) {
                                if (data.isFavorite == '4') {
                                    $this.data('favorite', 'true');
                                    $this.find('i').removeClass('far').addClass('fas');
                                } else if(data.isFavorite == '0' || data.fav == '1') {
                                    $this.data('favorite', 'false');
                                    $this.find('i').removeClass('fas').addClass('far');
                                }
                            }
                        }
                    });
                });
            })
        </script>
    @endif
@endpush

@push("styles")
    <style>
        .offer-card { border: 1px solid #e5e7eb; border-left: 4px solid #cfd6df; border-radius: .5rem; transition: box-shadow .15s, transform .15s, border-color .15s; }
        .offer-card:hover { box-shadow: 0 .4rem 1rem rgba(0,0,0,.08); transform: translateY(-1px); border-left-color: #D88F32; }
        .offer-card--featured { border-left-color: #D88F32; }
        .offer-card .card-body { padding: 1rem 1.25rem; }
        .offer-card__header { display: flex; justify-content: space-between; align-items: flex-start; gap: .75rem; }
        .offer-card__title { font-size: 1.15rem; font-weight: 700; line-height: 1.3; }
        .offer-card__title a { text-decoration: none; }
        .offer-card__title a:hover { text-decoration: underline; }
        .offer-card__actions { display: flex; align-items: center; gap: .6rem; flex-shrink: 0; }
        .offer-card__badge { background: #D88F32; color: #fff; font-weight: 600; padding: .35em .65em; border-radius: 1rem; }
        .offer-card__fav { font-size: 1.25rem; line-height: 1; }
        .offer-card__company { margin-top: .35rem; color: #4b5563; font-size: .95rem; }
        .offer-card__date { color: #6b7280; font-size: .85rem; }
        .offer-card__meta { display: flex; flex-wrap: wrap; gap: .5rem; margin: .75rem 0; }
        .offer-card__chip { display: inline-flex; align-items: center; gap: .4rem; background: #f3f4f6; color: #374151; border-radius: 1rem; padding: .25rem .7rem; font-size: .85rem; }
        .offer-card--featured .offer-card__chip { background: rgba(255,255,255,.6); }
        .offer-card__desc { margin: 0; color: #4b5563; font-size: .92rem; line-height: 1.5; }
        @media (max-width: 575.98px) {
            .offer-card .card-body { padding: .9rem 1rem; }
            .offer-card__title { font-size: 1.05rem; }
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
