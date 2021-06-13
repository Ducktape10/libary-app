@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Könyv módosítás</h1>
    <p class="mb-1">Ezen az oldalon tudsz könyvet módosítani.</p>
    <div class="mb-4">
        <a id="all-books-ref" href="{{ route('books.index') }}">Vissza a könyvekhez</a>
    </div>

    @if (Session::has('book-updated'))
        <div class="alert alert-success" role="alert">
            A(z) {{ Session::get('book-updated') }} nevű könyv sikeresen módosítva lett!
        </div>
    @endif

    <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Cím*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Könyv címe" value="{{ old('title') ? old('title') : $book->title }}">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="authors" class="col-sm-2 col-form-label">Szerző*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('authors') is-invalid @enderror" id="authors" name="authors" placeholder="Szerző" value="{{ old('authors') ? old('authors') : $book->authors }}">
                @error('authors')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="released_at" class="col-sm-2 col-form-label">Kiadás*</label>
            <div class="col-sm-10">
                <input type="date" class="form-control @error('released_at') is-invalid @enderror" id="released_at" name="released_at" value="{{ old('released_at') ? old('released_at') : $book->released_at }}">
                @error('released_at')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="pages" class="col-sm-2 col-form-label">Oldalszám*</label>
            <div class="col-sm-10">
                <input type="number" class="form-control @error('pages') is-invalid @enderror" id="pages" name="pages" placeholder="Oldalszám" value="{{ old('pages') ? old('pages') : $book->pages }}">
                @error('pages')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="isbn" class="col-sm-2 col-form-label">ISBN*</label>
            <div class="col-sm-10">
                <input type="number" class="form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn" placeholder="ISBN" value="{{ old('isbn') ? old('isbn') : $book->isbn }}">
                @error('isbn')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">Leírás*</label>
            <div class="col-sm-10">
                <textarea rows="5" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Könyv leírása">{{ old('description') ? old('description') : $book->description }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Műfaj</label>
            <div class="col-sm-10">
                <div class="row">
                    @forelse ($genres->chunk(5) as $chunk)
                        <div class="col-6 col-md-4 col-lg-2">
                            @foreach ($chunk as $genre)
                                <div class="form-check">
                                    <?php

                                    ?>
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        value="{{ $genre->id }}"
                                        id="genre{{ $genre->id }}"
                                        name="genres[]"
                                        @if ((is_array(old('genres')) && in_array($genre->id, old('genres'))) || $book->genres->contains($genre))
                                            checked
                                        @endif
                                    >
                                    <label
                                        for="genre{{ $genre->id }}"
                                        class="form-check-label"
                                    >
                                        <span class="badge badge-{{ $genre->style }}">
                                            {{ $genre->name }}
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <p>Nincsenek műfajok</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="attachment" class="col-sm-2 col-form-label">Borító</label>
            <div class="col-sm-10">
                <div class="form-group">
                    <input class="mb-3" type="file" class="form-control-file @error('attachment') is-invalid @enderror" id="attachment" name="attachment">
                    @error('attachment')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                    @if ($book->cover_image)
                        <div style="width:40vw;
                        height:40vh;">
                            <img style="max-width:100%;
                            height:auto;
                            max-height:100%;" id="book-cover-preview" src="{{ URL::asset('images/book_covers/' . $book->cover_image) }}" alt="{{ $book->cover_image }}">
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" value="1" id="remove_cover" name="remove_cover">
                            <label for="remove_cover" class="form-check-label">Borító törlése</label>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="in_stock" class="col-sm-2 col-form-label">Készletszám*</label>
            <div class="col-sm-10">
                <input type="number" class="form-control @error('in_stock') is-invalid @enderror" id="in_stock" name="in_stock" placeholder="Készlet szám" value="{{ old('in_stock') ? old('in_stock') : $book->in_stock }}">
                @error('in_stock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Módosít</button>
        </div>
    </form>
</div>
@endsection
