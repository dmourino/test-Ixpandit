<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pokémon Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-4">Pokemon Finder</h1>

    <h5 class="mb-4">El que quiera Pokemons, que los busque</h5>

    <form method="GET" action="{{ url('/') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Ingresar el nombre a buscar" value="{{ old('search', $search) }}">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>

    <h4 class="mb-4">Resultados de la búsqueda</h4>

    @if(count($pokemons))
        <ul class="list-group mb-4">
            @foreach($pokemons as $pokemon)
                <li class="list-group-item d-flex align-items-center">
                    @if($pokemon['image'])
                        <img src="{{ $pokemon['image'] }}" alt="{{ $pokemon['name'] }}" class="me-3" width="60">
                    @endif
                    <span class="fs-5 text-capitalize">{{ $pokemon['name'] }}</span>
                </li>
            @endforeach
        </ul>

        <div class="d-flex justify-content-center">
            {{ $pokemons->onEachSide(2)->links() }}
        </div>

    @else
        <div class="alert alert-warning">
            No se encontraron pokemones que coincidan con tu búsqueda.
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
