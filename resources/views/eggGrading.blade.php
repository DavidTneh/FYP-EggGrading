@extends('/admin')

@section('title', 'Egg Grading')

@section('content_header')
<h1>Egg Grading Module</h1>
@stop

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container" style="width: 100%; margin-top: 20px;">

    <div class="row">
        <div class="col-md-6">
            <label for="camera1-select">Select Camera 1:</label>
            <select id="camera1-select" class="form-control"></select>
        </div>
        <div class="col-md-6">
            <label for="camera2-select">Select Camera 2:</label>
            <select id="camera2-select" class="form-control"></select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Camera 1</h3>
                </div>
                <div class="card-body">
                    <div id="camera1" class="camera-display">
                        <video id="camera1-stream" width="100%" height="500px" controls autoplay muted></video>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Camera 2</h3>
                </div>
                <div class="card-body">
                    <div id="camera2" class="camera-display">
                        <video id="camera2-stream" width="100%" height="500px" controls autoplay muted></video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <button class="btn btn-success" id="startGrading" onclick="startGrading()">Start Grading</button>
            <button class="btn btn-danger" id="stopGrading" onclick="stopGrading()" disabled>Stop Grading</button>
            <a href="/eggResults" class="btn btn-primary" id="viewResults">View Results</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <h3 id="resultDisplay"></h3>
        </div>
    </div>
</div>

<script>
    let camera1Stream = null;
        let camera2Stream = null;
        let availableCameras = [];

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function getAvailableCameras() {
            try {
                const devices = await navigator.mediaDevices.enumerateDevices();
                availableCameras = devices.filter(device => device.kind === 'videoinput');
                const camera1Select = document.getElementById('camera1-select');
                const camera2Select = document.getElementById('camera2-select');

                availableCameras.forEach(camera => {
                    const option1 = new Option(camera.label || `Camera ${camera.deviceId}`, camera.deviceId);
                    const option2 = new Option(camera.label || `Camera ${camera.deviceId}`, camera.deviceId);
                    camera1Select.add(option1);
                    camera2Select.add(option2);
                });

                if (availableCameras.length === 0) {
                    console.error("No cameras found.");
                }
            } catch (err) {
                console.error("Error accessing cameras: ", err);
            }
        }

        async function startGrading() {
            document.getElementById('startGrading').disabled = true;
            document.getElementById('stopGrading').disabled = false;

            const camera1ID = document.getElementById('camera1-select').value;
            const camera2ID = document.getElementById('camera2-select').value;

            try {
                camera1Stream = await navigator.mediaDevices.getUserMedia({
                    video: { deviceId: { exact: camera1ID } }
                });
                document.getElementById('camera1-stream').srcObject = camera1Stream;

                camera2Stream = await navigator.mediaDevices.getUserMedia({
                    video: { deviceId: { exact: camera2ID } }
                });
                document.getElementById('camera2-stream').srcObject = camera2Stream;

                console.log('Grading started');
                processFrames();
            } catch (err) {
                console.error('Error accessing cameras:', err);
            }
        }

        function stopGrading() {
            document.getElementById('startGrading').disabled = false;
            document.getElementById('stopGrading').disabled = true;

            if (camera1Stream) {
                camera1Stream.getTracks().forEach(track => track.stop());
                camera1Stream = null;
            }
            if (camera2Stream) {
                camera2Stream.getTracks().forEach(track => track.stop());
                camera2Stream = null;
            }

            console.log('Grading stopped');
        }

        async function processFrames() {
            const camera1 = document.getElementById('camera1-stream');
            const camera2 = document.getElementById('camera2-stream');
            const captureInterval = 1000;

            const interval = setInterval(async () => {
                if (!camera1Stream || !camera2Stream) {
                    clearInterval(interval);
                    return;
                }

                const camera1Frame = captureFrame(camera1);
                const camera2Frame = captureFrame(camera2);

                const grades = await sendFramesToBackend(camera1Frame, camera2Frame);
                document.getElementById('resultDisplay').innerText = "Final Grade: " + grades.finalGrade;
            }, captureInterval);
        }

        function captureFrame(videoElement) {
            const canvas = document.createElement("canvas");
            canvas.width = videoElement.videoWidth;
            canvas.height = videoElement.videoHeight;

            const ctx = canvas.getContext("2d");
            ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

            return canvas.toDataURL("image/jpeg", 1.0); // High-quality JPEG
        }

        async function sendFramesToBackend(frame1, frame2) {
            try {
                const response = await fetch('/api/gradeEggs', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': csrfToken,
                    },
                    body: JSON.stringify({ frame1, frame2 }),
                });

                if (!response.ok) {
                    const errorMessage = await response.json();
                    throw new Error(`HTTP error! status: ${response.status}, message: ${errorMessage.error}`);
                }

                return await response.json();
            } catch (error) {
                console.error("Error sending frames to backend:", error);
                alert(`An error occurred: ${error.message}`);
                return { finalGrade: "Error" };
            }
        }

        document.addEventListener('DOMContentLoaded', getAvailableCameras);
</script>
@stop