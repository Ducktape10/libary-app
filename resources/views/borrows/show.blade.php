@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            @if (Session::has('borrow-updated'))
                <div id="book-deleted" class="alert alert-success" role="alert">
                    A kölcsönzése módosítva lett!
                </div>
            @endif
            <h1 id="book-title">{{ $borrow->book->title }} kölcsönzési kérelem</h1>
            <p>Név: {{ $borrow->reader->name }}</p>
            <p>Könyv címe: {{ $borrow->book->title }}</p>
            @if($borrow->reader_message)
                <p>Üzenet: {{ $borrow->reader_message }}</p>
            @endif
            <p>Dátum: {{ $borrow->created_at }}</p>
            <p>Állapot: {{ $borrow->status }}</p>
            @if($borrow->status != 'PENDING')
                <p>Feldolgozás ideje: {{ $borrow->request_processed_at }}</p>
                <p>Feldolgozást végző könyvtáros: {{ $borrow->request_managed_by }}</p>
                @if($borrow->request_processed_message)
                    <p>Könyvtáros megjegyzése: {{ $borrow->request_processed_message }}</p>
                @endif
                @if($borrow->deadline)
                    <p>Határidő: {{ $borrow->deadline }}</p>
                @endif
                @if($borrow->status == 'RETURNED')
                    <p>Visszaadás ideje: {{ $borrow->returned_at }}</p>
                    <p>Átvevő könyvtáros: {{ $borrow->return_managed_by }}</p>
                @endif
            @endif

            @if(Auth::user() && Auth::user()->is_libarian == 1)
            <a href="{{ route('borrows.edit', $borrow) }}" id="all-borrows-ref">Módosít</a>
            @endif


            <div class="mb-3">
                <a href="{{ route('borrows.index') }}" id="all-borrows-ref">Vissza a kölcsönzésekhez</a>
            </div>
        </div>
    </div>
</div>
@endsection
