@extends('layout.app')

@section('title', ' | ' . $business->business_meta->fantasy_name)

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4>
                                    Empresa {{ $business->business_meta->fantasy_name }}
                                </h4>
                            </div>
                            <div class="col-6">
                                <p>Esta empresa tiene {{ $business->offers_count }} ofertas publicadas</p>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <p>Dirección: {{ $business->business_meta->address }}</p>
                                <p>Comuna: {{ $business->business_meta->comune }}</p>
                                <p>Ciudad: {{ $business->business_meta->city }}</p>
                            </div>
                            <div class="col-6">
                                <p>Email: {{ $business->email_user }}</p>
                                <p>Teléfono: {{ $business->business_meta->phone }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                @forelse($business->offers as $offer)
                                    <p><a href="{{ route('offer.show', $offer->slug) }}">{{$offer->title}}</a></p>
                                @empty
                                    <p>Esta empresa aun no publica ofertas</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection