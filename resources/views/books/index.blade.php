@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('books.index') }}" method="GET" enctype="multipart/form-data">
        <div class="input-group mb-3">
            <input type="text" name="title" class="form-control" placeholder="Könyv címe" aria-label="Könyv címe" aria-describedby="basic-addon2">
            <div class="input-group-append">
            <button class="btn btn-primary book-details" type="submit">Keresés</button>
            </div>
        </div>
    </form>
    <div class="text-md-right mb-3">
        @if(Auth::user())
            <a href="{{ route('borrows.index') }}" id="create-genre-btn" class="btn btn-primary book-details">Kölcsönzések</a>
        @endif
        @can('create', App\Book::class)
            <a href="{{ route('genres.create') }}" id="create-genre-btn" class="btn btn-primary book-details">Új műfaj</a>
            <a href="{{ route('books.create') }}" id="create-book-btn" class="btn btn-primary book-details">Új könyv</a>
        @endcan
    </div>
    @if (Session::has('book-deleted'))
        <div id="book-deleted" class="alert alert-danger" role="alert">
            A(z) <span id="book-name">{{ Session::get('book-deleted') }}</span> nevű könyv törölve lett!
        </div>
    @endif
    @if (Session::has('genre-deleted'))
        <div id="genre-deleted" class="alert alert-danger" role="alert">
            A(z) <span id="genre-name">{{ Session::get('genre-deleted') }}</span> nevű műfaj törölve lett!
        </div>
    @endif
    <div class="row mt-3">
        <div class="col-12 col-lg-9">
            <div id="books" class="row">
                @forelse($books as $book)
                    <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-items-strech">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-2">
                                    <h5 id="book-title" class="card-title mb-0 book-title">{{ $book->title }}</h5>
                                    <small class="text-secondary">
                                        <span class="mr-2">
                                            <span class="book-author">{{ $book->authors ? $book->authors : 'Nincs szerző' }}</span>
                                        </span>
                                        <span class="mr-2">
                                            <span class="book-date">{{ $book->created_at->format('Y. m. h.') }}</span>
                                        </span>
                                    </small>
                                </div>
                                <p class="card-text book-description">{!! Str::of(e($book->description)) !!}</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('books.show', $book) }}" class="btn btn-primary book-details">Megtekint</a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Statisztika</h5>
                            <span class="stats-books">Könyvek száma: {{ $booksAllCount }}</span><br>
                            <span class="stats-genres">Műfajok száma: {{ $genres->count() }}</span><br>
                            <span class="stats-users">Felhasználók száma: {{ $userCount }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="card bg-light">
                        <div class="card-body genres-list">
                            <h5 class="card-title mb-2">Műfajok</h5>
                            <p class="small">Könyvek megtekintése műfaj szerint.</p>
                            @forelse($genres as $genre)
                                <a href="{{ route('genres.show', $genre) }}" class="badge badge-{{ $genre->style }}">{{ $genre->name }}</a>
                            @empty
                                Nem található műfaj
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($page && $page > 1)
        @if ($title)
            <a href="{{ route('books.index', 'page=' . ($page - 1) . '&title=' . $title) }}" id="create-genre-btn" class="btn btn-primary book-details">Előző oldal</a>
        @else
            <a href="{{ route('books.index', 'page=' . ($page - 1)) }}" id="create-genre-btn" class="btn btn-primary book-details">Előző oldal</a>
        @endif
    @endif

    @if ($page)
        @if ($booksCount > $page * 9)
            @if ($title)
                <a href="{{ route('books.index', 'page=' . $page + 1 . '&title=' . $title) }}" id="create-book-btn" class="btn btn-primary book-details">Következő oldal</a>
            @else
                <a href="{{ route('books.index', 'page=' . $page + 1) }}" id="create-book-btn" class="btn btn-primary book-details">Következő oldal</a>
            @endif
        @endif
    @elseif($booksCount > 9)
        @if ($title)
            <a href="{{ route('books.index', 'page=' . 2 . '&title=' . $title) }}" id="create-book-btn" class="btn btn-primary book-details">Következő oldal</a>
        @else
            <a href="{{ route('books.index', 'page=' . 2) }}" id="create-book-btn" class="btn btn-primary book-details">Következő oldal</a>
        @endif
    @endif
</div>
@endsection
