@extends('layouts.app')

@section('content')
<div class="max-w-screen-md p-6 mx-auto leading-7 bg-white border border-gray-200 rounded-md shadow-sm">
    <h2 class="mb-5 text-xl font-bold">Introductie</h2>
    <p>
        Bedankt voor het openen van de link. In de komende 6 video’s krijgt u verschillende verkeerssituaties te zien.
    </p>
    <p class="mt-3">
        Klik op het scherm om interessante objecten voor een gemiddelde autobestuurder aan te geven, denk hierbij aan fietsers, voetgangers, verkeersborden etc. U kunt daarbij onderscheid maken tussen <strong>must-be-seen</strong> en <strong>may-be-seen</strong> objecten.
    </p>

    <div class="my-10">
        <p class="mx-5 mt-3">
            <strong>Must-be-seen:</strong> Met deze objecten dient de autobestuurder actief dan wel passief rekening te houden en deze objecten beïnvloeden het rijgedrag van de autobestuurder op enige manier, zoals remmen, van richting veranderen, later optrekken, etc.
        </p>
        <hr class="mx-10 my-5">
        <p class="mx-5 mt-3">
            <strong>May-be-seen:</strong> Deze objecten zijn relevant om gezien te hebben als autobestuurder, maar vereisen geen verandering in het rijgedrag, zoals een fietser op het fietspad, voetganger op de stoep, tegenligger op de andere rijbaan etc.
        </p>
    </div>

    <a href="{{ route('start') }}" class="inline-block px-3 py-1 mt-5 text-lg text-gray-400 underline rounded-md">&laquo; Gegevens</a>
    <a href="{{ route('instructies') }}" class="inline-block px-3 py-1 mt-5 text-lg text-white bg-blue-400 rounded-md">Naar instructies &raquo;</a>
</div>
@endsection
