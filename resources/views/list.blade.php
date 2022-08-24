@extends('layouts.app')

@section('content')
<ul class="mt-15">
    @foreach($files as $file)
    <li class="my-8">
        @if($file['replay'] !== false)
        <a href="{{ $file['replay'] }}" class="px-4 py-3 mr-5 bg-white rounded-md shadow-md hover:text-blue-900 hover:bg-blue-100" target="_blank">
            Replay video
        </a>
        @endif

        <a href="{{ $file['url'] }}" class="px-4 py-3 bg-white rounded-md shadow-md hover:text-blue-900 hover:bg-blue-100" target="_blank">
            {{ $file['name'] }}
        </a>
    </li>
    @endforeach
</ul>
@endsection
