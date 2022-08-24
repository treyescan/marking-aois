@extends('layouts.app')

@section('content')
<div class="max-w-screen-md p-6 mx-auto leading-7 bg-white border border-gray-200 rounded-md shadow-sm">
    <h2 class="mb-5 text-xl font-bold">Instructies</h2>
    <p class="mt-3">
        Door de shift toets ingedrukt te houden en vervolgens met de muis te klikken wordt een must-be-seen hazard met een <strong>rode cirkel</strong> aangegeven. Een may-be-seen hazard geeft u aan door enkel op het scherm te klikken en wordt met een <strong>witte cirkel</strong> aangegeven. Het is mogelijk de video te pauzeren en dan te klikken. Ook kan de video worden teruggespoeld en kan gekeken worden welke objecten er zijn aangegeven, waarna er aanvullingen kunnen worden gedaan. Het is niet van belang wanneer u klikt, enkel dat u het object markeert. Reactiesnelheid speelt dus geen rol!
    </p>
    <p class="mt-3">
        <strong>Let op.</strong> Indien er een fout is gemaakt bij het onderscheid tussen may-be-seen en must-be-seen hazards, kunt u onder de video het object verwijderen door op het prullenbak icoontje te klikken. Door terug te spoelen kan dan nogmaals de juiste benaming voor het object worden gekozen.
    </p>
    <p class="mt-3">
        De resultaten worden automatisch naar ons toegestuurd.
    </p>
    <p class="mt-3">
        U kunt de video's enkel openen in moderne browsers (aangeraden: Google Chrome). Uw browserscherm moet minstens 1280px breed zijn om de video's te kunnen openen.
    </p>
    <p class="mt-3">
        We zullen eerst beginnen met een demo-video om te oefenen. Daarna zullen de 6 definitieve video’s verschijnen.
    </p>
    <div class="p-5 mt-5 bg-gray-100 rounded-md ">
        <p class="leading-8 ">
            <strong class="mb-3">Bediening</strong><br />
            <ul>
                <li><code>[Spatiebalk]</code>: Afspelen of pauseren</li>
                <li><code>[Shift + Klik]</code>: Markeer "<strong>must</strong> be seen hazard"</li>
                <li><code>[Klik]</code>: Markeer "<strong>may</strong> be seen hazard"</li>
            </ul>
        </p>
    </div>
    <a href="{{ route('introductie') }}" class="inline-block px-3 py-1 mt-5 text-lg text-gray-400 underline rounded-md">&laquo; Introductie</a>
    <a href="{{ route('video', [session()->get('id'), 0]) }}" class="inline-block px-3 py-1 mt-5 text-lg text-white bg-blue-400 rounded-md">Naar demo-video &raquo;</a>
</div>
@endsection
