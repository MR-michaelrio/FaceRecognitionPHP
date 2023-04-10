<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeSeem Face Detection</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* .upload-form{
            display: none;
        } */
    </style>
</head>
<body>

<video id="video" width="640" height="480" autoplay></video>
<canvas id="canvas" class="upload-form" width="640" height="480"></canvas>
<button id="capture-btn">Capture Image</button>

	<form id="upload-form" class="upload-form" method="POST" action="/facerecognition">
        @csrf
		<input id="image-input" type="hidden" name="image">
		<button id="upload-btn" type="submit">Upload Image</button>
	</form>

    <script defer src="./js/face-api.min.js"></script>
    <script defer src="./js/main.js"></script>
</body>
</html>