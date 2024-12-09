@extends('admin')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
    <h1>Chickens in Cage: {{ $cage->name }} | Breed: {{ $breed->name }}</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Chicken ID</th>
                <th>Date of Birth</th>
                <th>QR Code</th>
                <th>Actions</th>
                <th>Vaccination Summary</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chickens as $chicken)
            <tr>
                <td>{{ $chicken->chickenID }}</td>
                <td>{{ $chicken->dob }}</td>
                <td>
                    @if($chicken->qrCode)
                    <img id="qrCodeImage-{{ $chicken->chickenID }}" src="{{ $chicken->qrCode }}"
                        alt="QR Code for Chicken" style="width:100px; height:100px;">
                    <button class="btn btn-success btn-sm"
                        onclick="printQRCode('qrCodeImage-{{ $chicken->chickenID }}')">
                        Print QR
                    </button>
                    @else
                    No QR Code Available
                    @endif
                </td>
                <td>
                    <form action="{{ route('chickens.edit') }}" method="POST" style="display:inline;">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="chickenID" value="{{ $chicken->chickenID }}">
                        <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                    </form>

                    <form action="{{ route('chickens.destroy') }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="chickenID" value="{{ $chicken->chickenID }}">
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this chicken?')">Delete</button>
                    </form>
                </td>
                <td>
                    @if($chicken->vaccinationRecords->isEmpty())
                    <p>No Vaccination Records</p>
                    @else
                    @php
                    // Group vaccination records by vaccine name and count occurrences
                    $vaccineSummary = $chicken->vaccinationRecords
                    ->groupBy(function ($record) {
                    return $record->vaccinationplan->vaccinationType->vaccineName ?? 'Unknown Vaccine';
                    })
                    ->map(function ($records) {
                    return $records->count();
                    });
                    @endphp
                    <ul>
                        @foreach($vaccineSummary as $vaccineName => $count)
                        <li>{{ $vaccineName }}: {{ $count }} time(s)</li>
                        @endforeach
                    </ul>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('chickens.index') }}" class="btn btn-secondary mt-3">Back to Chicken Management</a>
</div>

<script>
    function printQRCode(imageId) {
        const qrImage = document.getElementById(imageId).outerHTML;
        const newWindow = window.open('', '_blank', 'width=600,height=600');
        newWindow.document.write(`
            <html>
            <head>
                <title>Print QR Code</title>
                <style>
                    body { display: flex; justify-content: center; align-items: center; height: 100%; margin: 0; }
                </style>
            </head>
            <body>
                ${qrImage}
                <script>
                    window.onload = function () { window.print(); window.close(); };
                <\/script>
            </body>
            </html>
        `);
        newWindow.document.close();
    }
</script>
@stop