@extends('layouts.master')

@section('title')
Liste de tous les produits
@endsection

@section('content')
    
{{-- pagination de Laravel --}}
{{ $products->links() }}

<ul class="list-group">
@forelse($products as $product)
    <li class="list-group-item">
        <h4><a href="{{ route('show_product', $product->id) }}">{{ $product->title }}</a></h4>
        <p>{{ $product->description}}</p>
        <p>{{ $product->price }}</p>
        <p>{{ $product->url_image }}</p>
        <p>{{ $product->code }}</p>
        <p>{{ $product->reference }}</p>
        @if( is_null($product->url_image) == false)
        <div class="row">
           <div class="col-xs-6 col-md-3">
                <a href="{{ route('show_product', $product->id) }}">
                    <img width="171" src="{{ asset('images/' . $product->url_image ) }}" alt="{{ $product->title }}" />
                </a>
           </div>
        </div>
        @endif

    </li>
@empty
@endforelse
</ul>

{{-- pagination de Laravel --}}
{{ $products->links() }}
@endsection