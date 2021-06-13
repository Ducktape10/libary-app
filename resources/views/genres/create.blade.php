@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Új műfaj</h1>
    <p class="mb-1">Ezen az oldalon tudsz új műfajt létrehozni. A könyvekhez úgy tudod hozzárendelni, ha a
        műfaj létrehozása után módosítod a bejegyzést, és ott bejelölöd ezt a műfajt is.</p>
    <div class="mb-4">
        <a href="{{ route('books.index') }}" id="all-books-ref">Vissza a könyvekhez</a>
    </div>

    @if (Session::has('genre-created'))
        <div id="genre-created" class="alert alert-success" role="alert">
            A(z) <span id="genre-name">{{ Session::get('genre-created') }}</span> nevű műfaj sikeresen létrejött!
        </div>
    @endif

    <form action="{{ route('genres.store') }}" method="POST">
        @csrf
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Név*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Műfaj neve" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Stílus*</label>
            <div class="col-sm-10">
                @foreach ($styles as $style)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="style" id="style-{{ $style }}" value="{{ $style }}" {{ old('style') === $style ? 'checked': '' }}>
                        <label class="form-check-label" for="style-{{ $style }}">
                            <span class="badge badge-{{ $style }}">{{ $style }}</span>
                        </label>
                    </div>
                @endforeach

                @error('style')
                    <p class="small text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Létrehoz</button>
        </div>
    </form>
</div>
@endsection
