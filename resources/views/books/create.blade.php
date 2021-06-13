@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Új könyv</h1>
    <p class="mb-1">Ezen az oldalon tudsz új könyvet létrehozni.</p>
    <div class="mb-4">
        <a id="all-books-ref" href="{{ route('books.index') }}">Vissza a könyvekhez</a>
    </div>

    @if (Session::has('book-created'))
        <div class="alert alert-success" role="alert">
            A(z) {{ Session::get('book-created') }} nevű könyv sikeresen létrejött!
        </div>
    @endif

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Cím*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Könyv címe" value="{{ old('title') }}">
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
                <input type="text" class="form-control @error('authors') is-invalid @enderror" id="authors" name="authors" placeholder="Szerző" value="{{ old('authors') }}">
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
                <input type="date" class="form-control @error('released_at') is-invalid @enderror" id="released_at" name="released_at" value="{{ old('released_at') }}">
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
                <input type="number" class="form-control @error('pages') is-invalid @enderror" id="pages" name="pages" placeholder="Oldalszám" value="{{ old('pages') }}">
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
                <input type="number" class="form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn" placeholder="ISBN" value="{{ old('isbn') }}">
                @error('isbn')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="text" class="col-sm-2 col-form-label">Leírás*</label>
            <div class="col-sm-10">
                <textarea rows="5" class="form-control @error('text') is-invalid @enderror" id="text" name="text" placeholder="Könyv leírása">{{ old('text') }}</textarea>
                @error('text')
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
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        value="{{ $genre->id }}"
                                        id="genre{{ $genre->id }}"
                                        name="genres[]"
                                        @if (is_array(old('genres')) && in_array($genre->id, old('genres')))
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
                    <input type="file" class="form-control-file @error('attachment') is-invalid @enderror" id="attachment" name="attachment">
                    @error('attachment')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="in_stock" class="col-sm-2 col-form-label">Készletszám*</label>
            <div class="col-sm-10">
                <input type="number" class="form-control @error('in_stock') is-invalid @enderror" id="in_stock" name="in_stock" placeholder="Készlet szám" value="{{ old('in_stock') }}">
                @error('in_stock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Létrehoz</button>
        </div>
    </form>
</div>
@endsection
