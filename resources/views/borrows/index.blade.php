@extends('layouts.app')

@section('content')
<div class="container">
    <div class="btn-group" role="group" aria-label="Basic example">
        <a type="button" class="btn btn-info" href="{{ route('borrows.index', 'status=PENDING') }}">Függő</a>
        <a type="button" class="btn btn-info" href="{{ route('borrows.index', 'status=ACCEPTED') }}">Elfogadott</a>
        <a type="button" class="btn btn-info" href="{{ route('borrows.index', 'status=REJECTED') }}">Elutasított</a>
        <a type="button" class="btn btn-info" href="{{ route('borrows.index', 'status=RETURNED') }}">Visszahozott</a>
        <a type="button" class="btn btn-info" href="{{ route('borrows.index', 'status=LATE') }}">Késés</a>
    </div>
    <div class="row mt-3">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Cím</th>
                    <th scope="col">Megjegyzés</th>
                    <th scope="col">Kérés dátum</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($borrows as $borrow)
                @php
                    $book = $borrow->book;
                @endphp
                @if($book)
                    <tr>
                        <td><a href="{{ route('borrows.show', $borrow) }}">{{ $borrow->id }}</a></td>
                        <td><a href="{{ route('books.show', $book) }}">{{ $book->title }}</a></td>
                        <td>{{ $borrow->reader_message }}</td>
                        <td>{{ $borrow->created_at }}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
