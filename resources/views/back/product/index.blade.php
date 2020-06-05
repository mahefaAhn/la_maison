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
                <td> {{ ($product->status==='published') ? 'Publié' : 'Brouillon' }} </td>
                <td class="txt-white"> <a href="{{route('product.edit', $product->id)}}"><button class="btn btn-warning"><span class="fa fa-edit" aria-hidden="true"></span> Modifier</button></a> </td>
                <td class="txt-white">
                    <form class="delete" method="POST" action="{{route('product.destroy', $product->id)}}">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input class="btn btn-danger" type="submit" value="Supprimer" >
                    </form>
                </td>
            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>

{{-- pagination de Laravel --}}
{{ $products->links() }}
@endsection