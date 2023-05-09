@extends('layout.template')

@section('title')
    Absen
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <video id="video" style="border: 1px solid black;" width="640" height="480" autoplay></video>
        <canvas id="canvas" class="canvas-form" width="640" height="480" hidden></canvas>
        <button id="capture-btn" style="display:none">Capture Image</button>

        <form id="upload-form" class="upload-form" method="POST" action="/facerecognition">
            @csrf
            <input id="image-input"  type="hidden" name="image">
            <button id="upload-btn" style="display:none" type="submit">Upload Image</button>
        </form>
    </div>
</div>
<script defer src="./js/face-api.min.js"></script>
<script defer src="./js/main.js"></script>
@endsection