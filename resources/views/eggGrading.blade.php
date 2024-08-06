@extends('/admin')

@section('title', 'Egg Grading')

@section('content_header')
    <h1>Egg Grading Module</h1>
@stop

@section('content')
<div class="container" style="width: 100%; margin-top: 20px;">
    <div class="row">
        <!-- Camera Display Section -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Camera 1</h3>
                </div>
                <div class="card-body">
                    <div id="camera1" class="camera-display">
                        <!-- Display video stream from Camera 1 -->
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
                        <!-- Display video stream from Camera 2 -->
                        <video id="camera2-stream" width="100%" height="500px" controls autoplay muted></video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Control Buttons -->
        <div class="col-md-12 text-center">
            <button class="btn btn-success" id="startGrading" onclick="startGrading()">Start Grading</button>
            <button class="btn btn-danger" id="stopGrading" onclick="stopGrading()" disabled>Stop Grading</button>
            <button class="btn btn-primary" id="viewResults">View Results</button>
        </div>
    </div>
</div>

<script>
    let camera1Stream = null;
    let camera2Stream = null;

    function startGrading() {
        document.getElementById('startGrading').disabled = true;
        document.getElementById('stopGrading').disabled = false;
        
        // Start camera streams
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                camera1Stream = stream;
                document.getElementById('camera1-stream').srcObject = stream;
            })
            .catch(err => {
                console.error('Error accessing camera 1: ', err);
            });
        
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                camera2Stream = stream;
                document.getElementById('camera2-stream').srcObject = stream;
            })
            .catch(err => {
                console.error('Error accessing camera 2: ', err);
            });
        
        console.log('Grading started');
    }

    function stopGrading() {
        document.getElementById('startGrading').disabled = false;
        document.getElementById('stopGrading').disabled = true;

        // Stop camera streams
        if (camera1Stream) {
            let tracks = camera1Stream.getTracks();
            tracks.forEach(track => track.stop());
            camera1Stream = null;
        }

        if (camera2Stream) {
            let tracks = camera2Stream.getTracks();
            tracks.forEach(track => track.stop());
            camera2Stream = null;
        }

        console.log('Grading stopped');
    }
</script>
@stop
