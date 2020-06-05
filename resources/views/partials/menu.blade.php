<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Boutique La-Maison</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <?php
                $urlAdmin = explode('/',request()->path())[0];
            ?>
            @if($urlAdmin==='admin')
                @if(Auth::check())
                    <li class="nav-item"><a class="nav-link {{ request()->path() === '/' ? 'active' : '' }}" href="{{ route('home') }}">Retour à l'accueil <span class="sr-only">(current)</span></a></li>
                    <li class="nav-item {{ request()->path() === '/admin' ? 'active' : '' }}"><a class="nav-link"  href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link"  href="{{ route('product.create') }}">Ajouter un produit</a></li>
                    <li class="nav-item"><a class="nav-link"  href="{{ route('admin') }}">Se déconnecter</a></li>
                @endif
            @else
                <li class="nav-item">
                    <a class="nav-link {{ request()->path() === '/' ? 'active' : '' }}" href="{{ route('home') }}">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item {{ request()->path() === '/soldes' ? 'active' : '' }}"><a class="nav-link"  href="{{ route('show_productSoldes') }}">Soldes</a></li>
                @if(isset($categories))
                    @forelse($categories as $id => $title)
                    <li class="nav-item {{ request()->id == $id ? 'active' : '' }}"><a class="nav-link"  href="{{ route('show_productByCategory', $id) }}">{{ ucfirst($title) }}</a></li>
                    @empty 
                    <li>Aucune catégorie pour l'instant</li>
                    @endforelse
                @endif
            @endif
        </ul>
    </div>
</nav>