@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h1 id="book-title">{{ $user->name }} profilja</h1>
            <p>Szerepkör: {{ $user->is_libarian == 1 ? 'Könyvtáros' : 'Olvasó' }}</p>
            <p>Könyv címe: {{ $user->email }}</p>

            @if($user->is_libarian == 1)
                <p>Elfogadott kölcsönzések száma: {{ $borrowsAcceptedCount }}</p>
                <p>Elutasított kölcsönzések száma: {{ $borrowsRejectedCount }}</p>
                <p>Késő kölcsönzések száma: {{ $borrowsReturnedCount }}</p>
            @else
                <p>Kölcsönzések száma: {{ $borrowsCount }}</p>
                <p>Aktív kölcsönzések száma: {{ $borrowsActiveCount }}</p>
                <p>Késő kölcsönzések száma: {{ $borrowsDeadlineCount }}</p>
            @endif

            <div class="mb-3">
                <a href="{{ route('borrows.index') }}" id="all-borrows-ref">Vissza a kölcsönzésekhez</a>
            </div>
        </div>
    </div>
</div>
@endsection
