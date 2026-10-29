@extends('layout.news')


@section('content')
<div class="categories-news">
    <h1 class="sr-only">Ofertas laborales por categoría</h1>
    @foreach($categories as $cat)
        <h2 class="text-white px-2 bg-secondary border border-start-0 border-end-0 py-1 fs-4">{{$cat->title}}</h2>
        @foreach($cat->Offers as $offer)
            <div class="h6 text-muted p-0 m-0">{{ $offer->created_at->format("d \\d\\e F \\d\\e Y") }}</div>
            <h3 class="pb-0 fs-5">
            <a href="{{route('offer.show', ['slug' => $offer->slug])}}" style="color: #f19001;" target="_blank">{{$offer->title}}</a>
            </h3>
        @endforeach
    @endforeach
</div>
@endsection