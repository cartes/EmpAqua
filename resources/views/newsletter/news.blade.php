@extends('layout.news')


@section('content')
<div class="categories-news">
    
    @foreach($categories as $cat)
        <h3 class="text-white px-2 bg-secondary border border-start-0 border-end-0 py-1 fs-4">{{$cat->title}}</h3>
        @foreach($cat->Offers as $offer)
            <h6 class="text-muted p-0 m-0">{{ $offer->created_at->format("d \\d\\e F \\d\\e Y") }}</h6>
            <h4 class="pb-0 fs-5">
            <a href="{{route('offer.show', ['slug' => $offer->slug])}}" style="color: #f19001;" target="_blank">{{$offer->title}}</a>
            </h4>
        @endforeach
    @endforeach
</div>
@endsection