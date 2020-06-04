@extends('layouts.master')

@section('title')
 {{ $titlePage }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        {{-- pagination de Laravel --}}
        {{ $products->links() }}
    </div>
    <div class="col-md-4">
        Hommes : 4 résultats<br>
        Femmes : 4 résultats<br>
    </div>
</div>

<div class="row product-list">
    @forelse($products as $product)
    <div class="col-md-3 product-div-block">
        <a href="{{ route('show_product', $product->id) }}">
            <div class="col-md-12 product-image-block" style="background-image : url({{ asset('images/' . $product->url_image ) }})">
            </div>
            <div class="col-md-12">
                <span class="product-name noTxtDecoration txtCenter">{{ $product->title }}</span>
                <span class="product-price noTxtDecoration txtCenter"><u>Prix :</u> {{ $product->price }} €</span>
            </div>
        </a>
    </div>
    <div class="col-md-1"></div>
    @empty
    @endforelse
</div>

{{-- pagination de Laravel --}}
{{ $products->links() }}
@endsection