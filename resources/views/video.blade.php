@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if($video->editable())
                    <form method="POST" action="{{ route('videos.update', $video->id) }}">
                        @method("put")
                        @csrf
                        @endif
                        <div class="card">
                            <div class="card-header">{{ $video->title }}</div>
                            <div class="card-body">
                                <video-js id="video" class="vjs-default-skin" controls preload="auto" width="640"
                                          height="268">
                                    <source
                                        src="{{ asset(\Illuminate\Support\Facades\Storage::url("videos/{$video->id}/{$video->id}.m3u8")) }}"
                                        type="application/x-mpegURL">
                                </video-js>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="mt-3">
                                            @if($video->editable())
                                                <input name="title" id="name" type="text" value="{{ $video->title }}"
                                                       style="width: 150%" class="form-control">
                                            @else
                                                {{ $video->title }}
                                            @endif
                                        </h4>
                                        {{ $video->views }} {{ \Illuminate\Support\Str::plural('view', $video->views) }}
                                    </div>
                                    {{----}}
                                    <votes :default_votes="{{ $video->votes }}" entity_id="{{ $video->id }}"
                                           entity_owner="{{ $video->channel->user_id }}"></votes>
                                </div>
                                <hr>
                                <div>
                                    @if($video->editable())
                                        <textarea class="form-control" name="description" id="description"
                                                  rows="3">{{ $video->description }}</textarea>
                                    @else
                                        <p>{{ $video->description ? $video->description : "No Description saved for this video" }}</p>
                                    @endif
                                </div>
                                @if($video->editable())

                                    @include('errors')

                                    <button type="submit" class="btn mt-2 btn-info">Update video details</button>
                                @endif
                                <hr>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="media">
                                        <img class="rounded-circle" src="https://picsum.photos/id/42/200/200" width="50"
                                             height="50" class="mr-3" alt="...">
                                        <div class="media-body ml-2">
                                            <h5 class="mt-0 mb-0">{{ $video->channel->name }}</h5>
                                            <span
                                                class="small">Published on {{ $video->created_at->toFormattedDateString() }}</span>
                                        </div>
                                    </div>
                                    <subscribe-btn :channel="{{ $video->channel }}"
                                                   :initial-subscriptions="{{ $video->channel->subscriptions }}"></subscribe-btn>
                                </div>
                            </div>
                        </div>
                        @if($video->editable())
                    </form>
                @endif

                <comments :video="{{ $video }}"></comments>


            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="https://vjs.zencdn.net/7.8.4/video-js.css" rel="stylesheet"/>
    <style>
        .vjs-default-skin {
            width: 100%;
        }

        .thumbs-up, .thumbs-down {
            width: 20px;
            height: 20px;
            cursor: pointer;
            fill: currentColor;
        }

        .thumbs-down-active, .thumbs-up-active {
            color: #3EA6FF;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://vjs.zencdn.net/7.8.4/video.js"></script>
    <script>
        window.CURRENT_VIDEO = "{{ $video->id }}";
    </script>
    <script src="{{ asset('js/player.js') }}"></script>
@endsection
