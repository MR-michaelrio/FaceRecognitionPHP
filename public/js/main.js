const video = document.getElementById('video');
const captureBtn = document.getElementById('capture-btn');
const canvas = document.getElementById('canvas');
const imageInput = document.getElementById('image-input');
const uploadForm = document.getElementById('upload-form');
let isCaptured = false;

Promise.all([
	faceapi.nets.tinyFaceDetector.loadFromUri('./models'),
	faceapi.nets.faceLandmark68Net.loadFromUri('./models'),
	faceapi.nets.faceRecognitionNet.loadFromUri('./models'),
	faceapi.nets.faceExpressionNet.loadFromUri('./models')
]).then(startVideo);

async function startVideo() {
	try {
		const stream = await navigator.mediaDevices.getUserMedia({ video: true });
		video.srcObject = stream;
	} catch (err) {
		if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
			console.log('Camera not found.');
			video.outerHTML = '<p>Camera not found.</p>';
		} else if (err.name === 'NotAllowedError') {
			console.log('Camera permission denied.');
			video.outerHTML = '<p>Camera permission denied.</p>';
		} else {
			console.log('Error accessing camera.');
			video.outerHTML = '<p>Error accessing camera.</p>';
		}
	}
}

function captureImage() {
	if (!isCaptured) {
		isCaptured = true;
		const context = canvas.getContext('2d');
		context.drawImage(video, 0, 0, canvas.width, canvas.height);
		const imageData = canvas.toDataURL('image/png');
		imageInput.value = imageData;
		uploadForm.submit();
	}
};

function startFunction(){
	const canvas = faceapi.createCanvasFromMedia(video);
	document.body.append(canvas);
	canvas.style.display = 'none';
	//Get video element width dan height nya
	const sizeEl = {width:video.width , height: video.height}
	//Match ukuran canvas dengan video elemen
	faceapi.matchDimensions(canvas, sizeEl);

	//Set interval setiap 0,1 detik
	setInterval(async function(){
		//Memanggil function untuk mendeteksi wajah di video webcam
		const detection = await faceapi.detectAllFaces(
			video,
			new faceapi.TinyFaceDetectorOptions()
		)
		.withFaceLandmarks()//Sistem deteksi menggunakan face landmark
		.withFaceExpressions()//Sistem deteksi menggunakan face expression
		//Membuat detection yang diresize menurut ukuran wajah
		const resizedSizeDetection = faceapi.resizeResults(detection, sizeEl);

		//Mengaplikasikan deteksi di canvas yang telah dibuat tadi, 
		//juga menghapus hasil deteksi yang sebelumnya
		canvas.getContext('2d').clearRect(0,0, canvas.width, canvas.height);
		faceapi.draw.drawDetections(canvas, resizedSizeDetection);
		//Untuk Mengecek terdeteksinya wajah
		if(detection.length>0){
			console.log('face detected');
			captureImage();
		}

	}, 1000);
}
video.addEventListener('playing', startFunction);
