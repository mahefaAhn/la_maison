@extends('layouts.master')

@section('title')
 {{ $titlePage }}
@endsection

@section('content')
<div class="row ">
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Boutique</a>
                </li>
                <li class="breadcrumb-item">
                    <!-- Code : Soldes / nouveau -->
                    <a href="{{ ($product->code==='solde')?route('show_productSoldes'):($product->code==='new')?route('show_productNew'):'' }}">{{ucfirst($product->code)}}</a>
                </li>
                <li class="breadcrumb-item">
                    <!-- Catégorie : Homme / Femme -->
                    <a href="{{ route('show_productByCategory', $product->category->id) }}">{{$product->category->title}}</a>
                </li>
            </ol>
        </nav>
    </div>
    <div class="col-md-6">
        <img src="{{ asset('images/' . $product->url_image ) }}" class="product-info-image"/>
    </div>
    <div class="col-md-6">
        <h2>{{ $titlePage }}</h2>
        <table>
            <tr>
                <th><u>Référence<u></th>
                <td>:{{$product->reference}} </td>
            </tr>
            <tr>
                <th>{{$product->price}} €</th>
                <td></td>
            </tr>
            <tr>
                <th><u>Taille<u></th>
                <td>
                    <select name="" class="form-control">
                        @for ($i = 0; $i < sizeof($product->getSizeArray()) ; $i++)
                            <option>{{ ($product->getSizeArray())[$i] }}</option>
                        @endfor
                    </select>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-12">
    <p>{{$product->description}}</p>
    </div>
</div>
@endsection