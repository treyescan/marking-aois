@extends('layouts.app')

@section('content')
<div class="max-w-lg p-6 mx-auto leading-7 bg-white border border-gray-200 rounded-md shadow-sm">
    <h2 class="mb-5 text-xl font-bold">Hazard perception test</h2>
    <form class="w-full px-3 mt-5 leading-8" method="POST" action="{{ route('start.session') }}">
        @csrf

        <div class="mb-2">
            <label for="naam" class="block text-sm font-medium text-gray-700">Initialen</label>
            <input type="text" name="naam" id="naam" value="{{ old('naam') }}" class="block w-full px-2 border border-gray-300 rounded-md appearance-none" autofocus>
            @error('naam') <p class="text-sm text-red-600 " id="email-error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-2">
            <label for="leeftijd" class="block text-sm font-medium text-gray-700">Leeftijd</label>
            <input type="text" name="leeftijd" id="leeftijd" value="{{ old('leeftijd') }}" class="block w-full px-2 border border-gray-300 rounded-md appearance-none" autofocus>
            @error('leeftijd') <p class="text-sm text-red-600 " id="email-error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-2">
            <label for="rijjaren" class="block text-sm font-medium text-gray-700">Rij-jaren</label>
            <input type="text" name="rijjaren" id="rijjaren" value="{{ old('rijjaren') }}" class="block w-full px-2 border border-gray-300 rounded-md appearance-none" autofocus>
            @error('rijjaren') <p class="text-sm text-red-600 " id="email-error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-2">
            <label for="cbr" class="block text-sm font-medium text-gray-700">CBR deskundige praktische rijgeschiktheid</label>
            <select name="cbr" id="cbr" class="block w-full p-2 border border-gray-300 rounded-md">
                <option value="none" disabled {{ !old('cbr') ? "selected" : "" }}>Kies:</option>
                <option {{ old('cbr') == 'ja' ? "selected" : "" }} value="ja">Ja</option>
                <option {{ old('cbr') == 'nee' ? "selected" : "" }} value="nee">Nee</option>
            </select>
            @error('cbr') <p class="text-sm text-red-600 " id="email-error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-2">
            <label for="stad" class="block text-sm font-medium text-gray-700">Rijdt veel in de stad</label>
            <select name="stad" id="stad" class="block w-full p-2 border border-gray-300 rounded-md">
                <option value="none" disabled {{ !old('stad') ? "selected" : "" }}>Kies:</option>
                <option {{ old('stad') == 'ja' ? "selected" : "" }} value="ja">Ja</option>
                <option {{ old('stad') == 'nee' ? "selected" : "" }} value="nee">Nee</option>
            </select>
            @error('stad') <p class="text-sm text-red-600 " id="email-error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-2">
            <label for="noclaim" class="block text-sm font-medium text-gray-700">No claim jaren</label>
            <input type="text" name="noclaim" id="noclaim" value="{{ old('noclaim') }}" class="block w-full px-2 border border-gray-300 rounded-md appearance-none" autofocus>
            @error('noclaim') <p class="text-sm text-red-600 " id="email-error">{{ $message }}</p> @enderror
        </div>

        <div class="block mt-5">
            <button type="submit" class="inline-block px-3 py-1 mt-5 text-lg text-white bg-blue-400 rounded-md">
                Naar Introductie &raquo;
            </button>
        </div>

        @if(session()->has('id'))
        <div class="mt-5 text-sm italic leading-5 text-gray-400">
            U bent reeds een bestaande sessie gestart. Wilt u een nieuwe sessie starten, klik dan hier: <a href="{{ route('reset') }}" class="text-gray-700 underline">reset gegevens</a>.
        </div>
        @endif
    </form>
</div>
@endsection
