@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            @if (Session::has('borrow-created'))
                <div class="alert alert-success" role="alert">
                    A(z) {{ Session::get('borrow-created') }} nevű könyv kölcsönzési kérelme sikeresen elküldve!
                </div>
            @endif

            @if (Session::has('borrow-deny'))
                <div class="alert alert-warning" role="alert">
                    A(z) {{ Session::get('borrow-deny') }} nevű könyvhöz már van kölcsönözési kérelmed!
                </div>
            @endif

            <h1 id="book-title">{{ $book->title }}</h1>

            <div class="d-flex my-1 text-secondary">
                <span class="mr-2">
                    <i class="fas fa-user"></i>
                    <span id="book-authors">{{
                        $book->authors
                            ? $book->authors
                            : 'Nincs szerző'
                        }}
                    </span>
                </span>
                <span class="mr-2">
                    <span id="book-date">{{ $book->created_at->format('Y. m. d.') }}</span>
                </span>

                <div id="book-genres" class="mb-2">
                    @foreach($book->genres as $genre)
                        <a href="{{ route('genres.show', $genre) }}" class="badge badge-{{ $genre->style }}">{{ $genre->name }}</a>
                    @endforeach
                </div>

                <span class="mr-2">
                    <span id="book-pages">{{ $book->pages }} oldal</span>
                </span>

                <span class="mr-2">
                    <span id="book-lang">{{ $book->language_code }} nyelv</span>
                </span>

                <span class="mr-2">
                    <span id="book-isbn">{{ $book->isbn }}</span>
                </span>

                <span class="mr-2">
                    <span id="book-isbn">{{ $book->in_stock }} darab elérhető</span>
                </span>
            </div>

            <div class="mb-2">
                <p class="card-text book-description">{!! Str::of(e($book->description)) !!}</p>
            </div>

            <div class="mb-3">
                <a href="{{ route('books.index') }}" id="all-books-ref">Minden könyv</a>
            </div>
        </div>

        <div class="col-12 col-md-4">
            @if(Auth::user() && Auth::user()->is_libarian == 0)
                <div class="py-md-3 text-md-right book-actions">
                    <p class="my-1">Könyv kölcsönzös:</p>
                    <a href="{{ $book->id }}/borrow" role="button" class="btn btn-sm btn-primary" id="edit-book-btn">Kölcsönzös</a>
                </div>
            @endif
            @can('update', $book)
                <div class="py-md-3 text-md-right book-actions">
                    <p class="my-1">Könyv kezelése:</p>
                    <a href="{{ route('books.edit', $book) }}" role="button" class="btn btn-sm btn-primary" id="edit-book-btn">Módosítás</a>
                    <form method="POST" action="{{route('books.destroy', $book->id) }}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger" id="delete-book-btn">Törlés</button>
                    </form>
                </div>
            @endcan
        </div>

    </div>

    <div class="mt-3">
        <p>{!! nl2br(e($book->text)) !!}</p>

        @if ($book->attachment_hash_name !== null)
            <div class="attachment mb-3">
                <h5>Csatolmány</h5>
                <a href="{{ route('books.attachment', ['id' => $book->id]) }}">{{ $book->attachment_original_name }}</a>
            </div>
        @endif

    </div>
</div>
@endsection
