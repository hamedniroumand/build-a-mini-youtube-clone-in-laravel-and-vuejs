<?php

namespace App\Http\Controllers;

use App\Http\Requests\videos\UpdateVideoRequest;
use App\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        if(\request()->wantsJson()){
            return $video;
        }
        return view('video', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function updateViews(Request $request, Video $video)
    {
        $video->increment('views');

        return response()->json([]);
    }

    public function update(Video $video ,UpdateVideoRequest $request)
    {
        $video->update($request->only(["title", "description"]));

        return redirect()->back();
    }
}
