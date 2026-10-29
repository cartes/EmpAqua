@extends('layout.newsletter')

@section('content')
    <div class="container">
        <h1 class="sr-only">Boletín de ofertas laborales</h1>
        <div class="row">
            @foreach($offersByCategory as $categoryName => $offers)
                <table class="table-borderless table">
                    <tr>
                        <td style="background: #e4e4e4; padding: 10px 20px;">
                            <h2 style="color: #666; padding: 0; margin: 0; font-size: 1.5rem">
                                {{ $categoryName }}
                            </h2>
                        </td>
                    </tr>
                    @foreach($offers as $offer)
                        <tr>
                            <td>
                                <a target="_blank" href="{{route('offer.show', ['slug' => $offer->slug])}}">
                                    {{ $offer->title }}
                                    @if($offer->featured)
                                        <span class="badge badge-primary">Destacado</span>
                                    @endif
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endforeach
        </div>
    </div>
@endsection
