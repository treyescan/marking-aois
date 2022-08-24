@extends('layouts.app')

@section('content')
@if($index == 0 && !$isReplay)
<div class="max-w-xl text-red-500">
    <h2 class="text-2xl font-bold">DEMO-VIDEO</h2>
    <p class="mb-5">
        De gegevens van deze video worden niet gebruikt in het onderzoek. U kunt dus eerst zoveel oefenen als u wilt. <br />
        [Shift + Klik]: must be seen hazard (rode cirkel). <br />
        [Klik]: may be seen hazard (witte cirkel).
    </p>
</div>
@elseif($index == 0 && $isReplay)
<h2 class="mb-5 text-2xl font-bold">Demo-video</h2>
@else
<h2 class="mb-5 text-2xl font-bold">Video {{ $index }}/6</h2>
@endif

@if($isReplay)
<p class="px-3 py-1 text-white bg-orange-500 rounded-t-lg">
    Replay mode
</p>
@endif


<div class="bg-white border border-gray-200">
    <div class="player">
        <video x-ref="video" {!! !$isReplay ? '@click="clickedVideo($event, {index: ' .$index.'})"' : '' !!} class="shadow-md viewer" @timeupdate="handleProgress" src="{{ $videoPath }}" type="video/mp4" @loadedmetadata="initTimes" /></video>

        <div class="player__controls">
            <div class="progress" x-ref="progress" @click="scrub($event)" @mousemove="moveScrub($event)" @mousedown="mousedown = true">
                <div class="progress__filled" x-ref="progressBar"></div>
            </div>
        </div>
    </div>
</div>

<div class="flex justify-between text-sm text-gray-400">
    <div>
        <span x-html="labelCurrentTime"></span> /
        <span x-html="labelDuration"></span>
        <span class="italic">(Speed: <span x-html="playbackSpeed"></span>x)</span>
    </div>

    <div>
        Sessie: {{ $sessionId }}
        <a href="#" class="text-indigo-300" x-show="rois.length > 0" @click="(showROIs = !showROIs), ($event.preventDefault())">(live)</a>
    </div>
</div>

<div class="flex mt-7">
    <div class="flex-1">
        <div class="inline-block p-5 bg-gray-200 rounded-lg">
            <a href="#" class="p-2 mr-2 text-sm text-white bg-green-400 rounded-md" @click="(play()), ($event.preventDefault())">
                <span class="align-middle material-icons">play_arrow</span>
                Video afspelen
            </a>
            <a href="#" class="p-2 mr-10 text-sm text-white bg-red-400 rounded-md" @click="(pause()), ($event.preventDefault())">
                <span class="align-middle material-icons">pause</span>
                Pauseer
            </a>

            <a href="#" class="p-2 mr-2 text-sm text-white bg-gray-800 rounded-md" @click="(rewind(5)), ($event.preventDefault())">
                <span class="align-middle material-icons">fast_rewind</span>
                5 sec
            </a>

            <a href="#" class="p-2 mr-10 text-sm text-white bg-gray-800 rounded-md" @click="(rewind(2)), ($event.preventDefault())">
                <span class="align-middle material-icons">fast_rewind</span>
                2 sec
            </a>

            <div class="inline text-sm text-gray-500">
                <span>Playback speed:</span>
                <input type="number" step="0.25" class="w-10 p-1 text-base text-black border-gray-300 rounded" x-model="playbackSpeed"> x
            </div>

            @if($isReplay)
            <div class="inline ml-5 text-sm text-gray-500">
                <input type="checkbox" id="autohide" name="autohide" x-model="autoHideAnimation" checked>
                <label for="autohide"><span>Auto hide animation</span></label>
                <a href="#" class="text-blue-600 underline" x-show="!autoHideAnimation" @click.prevent="hideAllAnimations">(clear all)</a>
            </div>
            @endif

        </div>

        <div class="mt-5">
            @if(!$isReplay)
            @if($index - 1 >= 0)
            <a href="{{ route('video', ['id' => $sessionId, 'index' => $index - 1]) }}" class="p-2 mr-2 text-sm text-gray-400 underline rounded-md">
                &laquo; Vorige video
            </a>
            @else
            <a href="{{ route('instructies') }}" class="p-2 mr-2 text-sm text-gray-400 underline rounded-md">
                &laquo; Naar instructies
            </a>
            @endif

            @if(($index + 1) < 7) <a href="{{ route('video', ['id' => $sessionId, 'index' => $index + 1]) }}" class="p-2 text-sm text-white bg-blue-400 rounded-md">
                Volgende video &raquo;
                </a>
                @else
                <a href="{{ route('done') }}" class="p-2 text-sm text-white bg-blue-400 rounded-md">
                    Klaar
                </a>
                @endif
                @endif
        </div>
    </div>
    <div class="flex-shrink text-right cursor-pointer" @click="(showROIs = !showROIs), ($event.preventDefault())">
        <div class="p-2 px-5 text-left bg-white border border-gray-300 rounded-md shadow-sm w-52">
            <span class="text-2xl text-gray-900"><span class="text-gray-400">ROI' s:</span> <span x-text="rois.length">0</span></span>
        </div>
    </div>
</div>

<div class="grid grid-cols-7 gap-4 mt-8" x-show="showROIs">
    <template x-for="(roi, index) in rois" :key="index">
        <a @click.prevent="removeRoi(index, {videoIndex: {{ $index }}, isReplay: {{ $isReplay ? 'true' : 'false' }}})" href="#" class="flex justify-between gap-2 px-2 py-1 text-sm text-gray-600 bg-white border border-gray-200 rounded-md shadow-sm group" x-bind:class="{ 'bg-red-100' : roi.type == 'must_be_seen' }" @mouseenter="(toolTip = true)">
            <div class="group-hover:line-through">
                <span x-text="roi.time"></span>s: (<span x-text="roi.x"></span>,
                <span x-text="roi.y"></span>)
            </div>

            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3 css-i6dzq1 group-hover:text-red-500">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                <line x1="10" y1="11" x2="10" y2="17"></line>
                <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>
        </a>
    </template>
</div>
@endsection
