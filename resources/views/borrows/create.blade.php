@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Új műfaj</h1>
    <p class="mb-1">Ezen az oldalon tudod a {{ $book->title }} című könyvet kölcsönözni.</p>
    <div class="mb-4">
        <a href="{{ route('books.show', $book) }}" id="all-books-ref">Vissza a könyv oldalára</a>
    </div>

    <form action="{{ route('borrows.store') }}" method="POST">
        @csrf
        <input type='hidden' name='bookId' value='{{$book->id}}'>
        <div class="form-group row">
            <label for="text" class="col-sm-2 col-form-label">Megjegyzés</label>
            <div class="col-sm-10">
                <textarea rows="5" class="form-control @error('text') is-invalid @enderror" id="text" name="text" placeholder="Megjegyzés a könyvtárosnak">{{ old('text') }}</textarea>
                @error('text')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Kölcsönzés</button>
        </div>
    </form>
</div>
@endsection
