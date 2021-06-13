@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kölcsönzés bírálása</h1>
    <p class="mb-1">Ezene az oldalon tudod bírálni a kölcsönzési igényeket.</p>
    <div class="mb-4">
        <a id="all-books-ref" href="{{ route('borrows.show', $borrow) }}"> Vissza a Kölcsönzésre</a>
    </div>

    <form action="{{ route('borrows.update', $borrow) }}" method="POST">
        @method('PATCH')
        @csrf
        <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">Státusz*</label>
            <div class="col-sm-10">
                @foreach ($statuses as $status)
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="status"
                            id="status-{{ $status }}"
                            value="{{ $status }}"
                            {{
                                old('status') === $status
                                    ? 'checked'
                                    : (
                                        $borrow->status === $status && !old('status')
                                            ? 'checked'
                                            : ''
                                    )
                            }}
                        >
                        <label class="form-check-label" for="style-{{ $status }}">
                            <span class="badge badge-{{ $status }}">{{ $status }}</span>
                        </label>
                    </div>
                @endforeach

                @error('style')
                    <p class="small text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="deadline" class="col-sm-2 col-form-label">Határidő</label>
            <div class="col-sm-10">
                <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="deadline" name="deadline" value="{{ old('deadline') }}">
                @error('deadline')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="request_processed_message" class="col-sm-2 col-form-label">Megjegyzés</label>
            <div class="col-sm-10">
                <textarea rows="5" class="form-control @error('request_processed_message') is-invalid @enderror" id="request_processed_message" name="request_processed_message" placeholder="Megjegyzés">{{ old('request_processed_message') }}</textarea>
                @error('request_processed_message')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Mentés</button>
        </div>
    </form>
</div>
@endsection
