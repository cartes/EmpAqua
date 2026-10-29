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
            @isset($search)
                <div class="col-md-12">
                    <h3>Resultados para: {{$search}}</h4>
                </div>
            @endisset
            <div class="col-10 col-sm-12">
                <h3>Todas las ofertas</h3>
            </div>
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

                    <div class="card mb-4{{ $offer->featured ? ' back-orange' : '' }}">
                        <div class="card-body row">
                            <div class="col-11">
                                <h5 class="card-title py-0">
                                    <a href="{{ route("offer.show", $offer->slug) }}">{{ $offer->title }}@if($offer->handicapped)  &nbsp;<i class="fas fa-wheelchair"></i>  @endif</a>
                                </h5>
                            </div>
                            <div class="col-12 col-sm-7 border-bottom mb-3 pb-3">
                                @if ($offer->businessMeta)
                                    @if(!$offer->confidential)
                                        <h6><strong>{{$offer->businessMeta->business_name}}</strong>
                                            - {{ $offer->publication }}</h6>
                                    @else
                                        <h6><strong>Confidencial</strong> - {{ $offer->publication }}</h6>
                                    @endif

                                @endif
                                @if ($offer->businessMeta)
                                    <div class="d-block d-sm-none">
                                        <div class="row">
                                            <div class="col-6">
                                                <h6><i class="fas fa-map-marker-alt"></i> &nbsp;<span
                                                            class="text-capitalize">{{ $offer->businessMeta->comune }}</span>
                                                </h6>
                                            </div>
                                            <div class="col-6">
                                                <i class="far fa-building"></i> &nbsp;<span
                                                        class="text-capitalize">{{ $offer->position }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-none d-sm-block">
                                        {{\Illuminate\Support\Str::limit(strip_tags(html_entity_decode($offer->description)), 150)}}
                                    </div>
                                @endif
                            </div>
                            <div class="col-5 d-block d-sm-block position-relative">
                                @if ($offer->businessMeta)
                                    <div class="d-none d-sm-block">
                                        <div class="row">
                                            <div class="col-6 col-sm-12">
                                                <h6><i class="fas fa-map-marker-alt"></i> &nbsp;<span
                                                            class="text-capitalize">{{ $offer->businessMeta->comune }}</span>
                                                </h6>
                                            </div>
                                            <div class="col-6 col-sm-12">
                                                <i class="far fa-building"></i> &nbsp;<span
                                                        class="text-capitalize">{{ $offer->position }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="position-absolute badge-destacado d-block d-md-block">
                                    @if ($offer->featured)
                                        <span class="badge">Destacada</span>
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
                                            <a class="post-add-fav d-block d-sm-inline-block" href="#" data-favorite="true" data-slug="{{$offer->slug}}">
                                                <i class="fas fa-bookmark"></i>
                                            </a>
                                            @else
                                            <a class="post-add-fav d-block d-sm-inline-block" href="#" data-favorite="false" data-slug="{{$offer->slug}}">
                                                <i class="far fa-bookmark"></i>
                                            </a>
                                            @endif
                                        @endisset
                                    @endif
                                </div>
                            </div>
                            <p class="card-text">
                            <p class="p-0 m-0 d-block d-sm-none">
                                {{\Illuminate\Support\Str::limit(strip_tags(html_entity_decode($offer->description)), 150)}}
                            </p>
                            </p>
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
    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
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
