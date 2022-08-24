<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DataController extends Controller
{
    public function __invoke(Request $request)
    {
        $folder = storage_path('app/public/data');
        $files = collect(glob($folder.'/*.csv'))->map(function ($file) {
            preg_match_all('/video_(?<index>\d)___session_(?<id>.*)\.csv/m', basename($file), $matches);

            return [
                'name' => basename($file),
                'url' => route('view', basename($file)),
                'replay' => (count($matches['id']) > 0) ? route('replay', [
                    'id' => $matches['id'][0],
                    'index' => $matches['index'][0],
                ]) : false,
            ];
        });

        return view('list', compact('files'));
    }

    public function view(Request $request, string $file)
    {
        return response(
            file_get_contents(storage_path('app/public/data/'.basename($file))),
            200
        )->header('Content-Type', 'text/plain');
    }

    public function add(RoiRequest $request)
    {
        $id = $request->session()->get('id');
        $index = $request->get('videoIndex');
        $file = storage_path('app/public/data/video_'.$index.'___session_'.$id.'.csv');
        $raw = file_get_contents($file);
        $raw .= PHP_EOL.$request->input('time').','.$request->input('x').','.$request->input('y').','.$request->input('type');
        file_put_contents($file, $raw);

        return ['success' => true];
    }

    public function remove(RoiRequest $request)
    {
        $id = session()->get('id');
        $index = $request->get('videoIndex');
        $file = storage_path('app/public/data/video_'.$index.'___session_'.$id.'.csv');
        $raw = file_get_contents($file);

        $toRemove = PHP_EOL.$request->input('time').','.$request->input('x').','.$request->input('y').','.$request->input('type');

        file_put_contents($file, str_replace($toRemove, '', $raw));
    }
}
