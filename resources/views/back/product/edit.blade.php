@extends('layouts.master')

@section('title')
 {{ $titlePage }}
@endsection

@section('content')
        <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title" class="col-sm-4 control-label">Nom</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="title" name="title" value="{{ $product->title }}" placeholder="Nom">
                            @if($errors->has('title')) <span class="error bg-warning">{{ $errors->first('title')}}</span> @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-4 control-label">Description</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="description" name="description" placeholder="Description" rows="5">{{ $product->description }}</textarea>
                            @if($errors->has('description')) <span class="error bg-warning">{{ $errors->first('description')}}</span> @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-sm-4 control-label">Prix</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="price" name="price" placeholder="Prix" value="{{ $product->price }}">
                            @if($errors->has('price')) <span class="error bg-warning">{{ $errors->first('price')}}</span> @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category" class="col-sm-4 control-label">Catégorie</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="category" name="category">
                                @forelse($categories as $id => $title)
                                <option value="{{ $id }}" {{ ($product->category->id===$id)?'selected':'' }}>{{ $title }}</option>
                                @empty
                                @endforelse
                            </select>
                            @if($errors->has('category')) <span class="error bg-warning">{{ $errors->first('category')}}</span> @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="size" class="col-sm-4 control-label">Taille</label>
                        <div class="col-sm-8">
                            <table>
                                <tr>
                                    <td>46</td>
                                    <td><input type="checkbox" {{ (in_array("46", $product->getSizeArray()))?'checked':'' }} class="bo-input-radio" name="size" id="size" value="46"/></td>
                                </tr>
                                <tr>
                                    <td>48</td>
                                    <td><input type="checkbox" {{ (in_array("48", $product->getSizeArray()))?'checked':'' }} class="bo-input-radio" name="size" id="size" value="48"/></td>
                                </tr>
                                <tr>
                                    <td>50</td>
                                    <td><input type="checkbox" {{ (in_array("50", $product->getSizeArray()))?'checked':'' }} class="bo-input-radio" name="size" id="size" value="48"/></td>
                                </tr>
                                <tr>
                                    <td>52</td>
                                    <td><input type="checkbox" {{ (in_array("52", $product->getSizeArray()))?'checked':'' }} class="bo-input-radio" name="size" id="size" value="48"/></td>
                                </tr>
                            </table>
                            @if($errors->has('size')) <span class="error bg-warning">{{ $errors->first('size')}}</span> @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="picture" class="col-sm-4 control-label">Image</label>
                        <div class="col-sm-8">
                            <input type="file" name="picture" id="picture" name="picture">
                            @if($errors->has('picture')) <br><span class="error bg-warning">{{ $errors->first('picture')}}</span> @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status" class="col-sm-4 control-label">Statut</label>
                        <div class="col-sm-8">
                            <table>
                                <tr>
                                    <td>Publié</td>
                                    <td><input type="radio" {{ $product->status === 'published' ? 'checked' : null }} class="bo-input-radio" name="status" id="status" value="published"/></td>
                                </tr>
                                <tr>
                                    <td>Brouillon</td>
                                    <td><input type="radio" {{ $product->status === 'unpublished' ? 'checked' : null }} class="bo-input-radio" name="status" id="status" value="unpublished"/></td>
                                </tr>
                            </table>
                            @if($errors->has('status')) <span class="error bg-warning">{{ $errors->first('status')}}</span> @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="code" class="col-sm-4 control-label">Code produit</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="code" name="code">
                                <option value="soldes">Soldes</option>
                                <option value="new">New</option>
                            </select>
                            @if($errors->has('code')) <span class="error bg-warning">{{ $errors->first('code')}}</span> @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reference" class="col-sm-4 control-label">Référence produit</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="reference" name="reference" placeholder="Référence produit" value="{{ $product->reference }}">
                            @if($errors->has('reference')) <span class="error bg-warning">{{ $errors->first('reference')}}</span> @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group col-md-10">
                        <button class="btn btn-warning col-sm-4" type="submit">Modifier</button>
                    </div>
                </div>
            </div>
        </form>
@endsection