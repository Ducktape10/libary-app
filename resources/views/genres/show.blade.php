@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h1 id="book-title"><span id="genre">{{ $genre->name }}</span> műfaj</h1>

            <div class="row mt-3">
                <div class="col-12 col-lg-12">
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
            </div>

            <div class="mb-3">
                <a href="{{ route('books.index') }}" id="all-books-ref">Minden könyv</a>
            </div>
        </div>
        @can('update', $genre)
            <div class="col-12 col-md-4">
                <div class="py-md-3 text-md-right genre-actions">
                    <p class="my-1">Műfaj kezelése:</p>
                    <a href="{{ route('genres.edit', $genre) }}" role="button" class="btn btn-sm btn-primary" id="edit-genre-btn">Módosítás</a>
                    <form method="POST" action="{{route('genres.destroy', $genre->id) }}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger" id="delete-genre-btn">Törlés</button>
                    </form>
                </div>
            </div>
        @endcan
    </div>
</div>
@endsection
