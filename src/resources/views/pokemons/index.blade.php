<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pokémon Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            list-style: none;
            padding: 0;
        }

        .pagination .page-link {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            margin: 0 5px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: #007bff;
        }

        .pagination .page-link:hover {
            background-color: #007bff;
            color: #fff;
        }

        .active .page-link {
            background-color: #28a745 !important;
            color: white !important;
            border-color: #28a745 !important;
            box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.5) !important;
        }

        .pagination .page-item.disabled .page-link {
            background-color: #e0e0e0;
            color: #bbb;
            border-color: #ddd;
        }

        .pagination .page-link {
            font-size: 14px;
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-4">Pokemon finder</h1>

    <h5 class="mb-4">El que quiera Pokemons, que los busque</h5>

    <form method="GET" action="{{ url('/') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Ingresar el nombre a buscar" value="{{ old('search', $search) }}">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>

    <h4 class="mb-4">Resultados de la búsqueda</h4>

    @if(count($pokemons))
        <ul class="list-group">
            @foreach($pokemons as $pokemon)
                <li class="list-group-item d-flex align-items-center">
                    @if($pokemon['image'])
                        <img src="{{ $pokemon['image'] }}" alt="{{ $pokemon['name'] }}" class="me-3" width="60">
                    @endif
                    <span class="fs-5 text-capitalize">{{ $pokemon['name'] }}</span>
                </li>
            @endforeach
        </ul>

        <div class="mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item {{ $pokemons->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $pokemons->url(1) }}" aria-label="Primera">
                            <span aria-hidden="true">&laquo;&laquo;</span>
                        </a>
                    </li>

                    <li class="page-item {{ $pokemons->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $pokemons->previousPageUrl() }}" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    @php
                        $currentPage = $pokemons->currentPage();
                        $totalPages = $pokemons->lastPage();
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($totalPages, $currentPage + 2);
                    @endphp

                    @for ($page = $startPage; $page <= $endPage; $page++)
                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ $pokemons->url($page) }}">{{ $page }}</a>
                        </li>
                    @endfor

                    <li class="page-item {{ $pokemons->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $pokemons->nextPageUrl() }}" aria-label="Siguiente">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>

                    <li class="page-item {{ !$pokemons->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $pokemons->url($pokemons->lastPage()) }}" aria-label="Última">
                            <span aria-hidden="true">&raquo;&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>


    @else
        <div class="alert alert-warning">
            No se encontraron pokemones que coincidan con tu búsqueda.
        </div>
    @endif
</div>
</body>
</html>
