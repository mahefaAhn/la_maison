@extends('layouts.master')

@section('title')
 {{ $titlePage }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>{{ $titlePage }}</h1>
    </div>
    <div class="col-md-8">
        {{-- pagination de Laravel --}}
        {{ $products->links() }}
    </div>
    <div class="col-md-4">
        <?php
            $nbProduct_homme = 0;
            $nbProduct_femme = 0;
            foreach($products as $product){
                if($product->category->id=='1') $nbProduct_homme++;
                if($product->category->id=='2') $nbProduct_femme++;
            }
        ?>
        Sur cette page :<br>
        Hommes : {{$nbProduct_homme}} résultat{{ ($nbProduct_homme==1)?'':'s' }}<br>
        Femmes : {{$nbProduct_femme}} résultat{{ ($nbProduct_femme==1)?'':'s' }}<br>
    </div>
</div>

<div class="row product-list">
    @forelse($products as $product)
    <div class="col-md-3 product-div-block">
        <a href="{{ route('show_product', $product->id) }}">
            <div class="col-md-12 product-image-block" style="background-image : url({{ asset('images/' . $product->url_image ) }})">
            </div>
            <div class="col-md-12 txtCenter noTxtDecoration">
                <span class="product-name">{{ $product->title }}</span>
                @if($product->code==="solde")
                <span class="product-code-solde">SOLDES!!!</span>
                @endif
                <br>
                <span class="product-price"><u>Prix :</u> {{ $product->price }} €</span>
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