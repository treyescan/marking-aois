<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\StartSessionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class MainController extends Controller
{
    /**
     * Show the form on /start.
     *
     * @param Request $request
     * @return void
     */
    public function startSessionForm(Request $request)
    {
        if (session()->has('user')) {
            session(['_old_input.naam' => session()->get('user.naam')]);
            session(['_old_input.leeftijd' => session()->get('user.leeftijd')]);
            session(['_old_input.rijjaren' => session()->get('user.rijjaren')]);
            session(['_old_input.cbr' => session()->get('user.cbr')]);
            session(['_old_input.stad' => session()->get('user.stad')]);
            session(['_old_input.noclaim' => session()->get('user.noclaim')]);
        }

        return view('gegevens');
    }

    /**
     * Post the form on /start.
     *
     * @param Request $request
     * @return void
     */
    public function startSession(StartSessionRequest $request)
    {
        // Save the values to the session
        $user = [
            'naam' => $request->get('naam'),
            'leeftijd' => $request->get('leeftijd'),
            'rijjaren' => $request->get('rijjaren'),
            'cbr' => $request->get('cbr'),
            'stad' => $request->get('stad'),
            'noclaim' => $request->get('noclaim'),
        ];
        session()->put('user', $user);

        if (!session()->has('id')) {
            // Generate a session ID by hashing the array
            $id = md5(json_encode($user));
            session()->put('id', $id);
        } else {
            $id = session()->get('id');
        }

        // Save all details to a file (with hash as ID)
        $file = storage_path('app/public/data/session_details_' . $id . '.csv');
        $user['session_id'] = $id;
        $user['date'] = date('Y-m-d');
        $user['time'] = date('H:i');
        file_put_contents($file, collect($user)->map(function ($item, $key) {
            return $key . ',' . $item;
        })->implode(PHP_EOL));

        return redirect()->route('introductie');
    }

    /**
     * Start hinting a video
     * also: replay a video.
     *
     * @param Request $request
     * @param string $id
     * @param int $index
     * @return void
     */
    public function video(Request $request, string $id, int $index = 0)
    {
        $isReplay = Route::current()->getName() == 'replay';

        if (!session()->has('id') && !$isReplay) {
            return redirect()->route('start');
        }

        // Check if we have a file in which we may save data points
        $file = storage_path('app/public/data/video_' . $index . '___session_' . $id . '.csv');
        $data = [];

        if (!file_exists($file)) {
            // If it doesn't exist: create an empty file
            file_put_contents($file, 'time,x,y,type');
        } else {
            $data = collect(array_map('str_getcsv', file($file)));

            // Get and remove headers from data
            $headers = collect($data->first());
            $data->shift();

            $data = $data->map(function ($point) use ($headers) {
                $point = collect($point);

                return [
                    $headers->get(0) => (float) $point->get(0),
                    $headers->get(1) => (int) $point->get(1),
                    $headers->get(2) => (int) $point->get(2),
                    $headers->get(3) => $point->get(3),
                ];
            });
        }

        $videoPath = asset('videos/video_' . $index . '.webm');
        if (\App::environment('local')) {
            $videoPath = config('app.video_url') . '/video_' . $index . '.webm';
        }

        return view('video', [
            'videoPath' => $videoPath,
            'sessionId' => $id,
            'data' => $data,
            'index' => $index,
            'isReplay' => $isReplay,
        ]);
    }

    public function resetSession()
    {
        session()->forget('id');
        session()->forget('user');
        session()->flush();

        return redirect()->route('start');
    }
}
