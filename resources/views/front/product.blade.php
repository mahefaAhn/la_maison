@extends('layouts.master')

@section('title')
 {{ $titlePage }}
@endsection

@section('content')
<div class="row ">
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
                <td> </td>
            </tr>
        </table>
    </div>
    <div class="col-md-12">
    <p>{{$product->description}}</p>
    </div>
</div>
@endsection