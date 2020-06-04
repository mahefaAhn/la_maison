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
    </div>
</div>

<div class="row bo-content-pg">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Catégorie</th>
                <th scope="col">Prix</th>
                <th scope="col">Statut</th>
                <th scope="col">Mettre à jour</th>
                <th scope="col">Supprimer</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td> {{ $product->title }} </td>
                <td> {{ $product->category->title }} </td>
                <td> {{ $product->price }} </td>
                <td> {{ ($product->status==='publish') ? 'Publié' : 'Brouillon' }} </td>
                <td class="txt-white"> <a href="{{route('product.edit', $product->id)}}"><button class="btn btn-warning"><span class="fa fa-edit" aria-hidden="true"></span> Modifier</button></a> </td>
                <td class="txt-white"> <a href="{{route('product.destroy', $product->id)}}"><button class="btn btn-danger"><span class="fa fa-trash" aria-hidden="true"></span> Supprimer</button></a> </td>
            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>

{{-- pagination de Laravel --}}
{{ $products->links() }}
@endsection