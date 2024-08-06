@extends('/admin')

@section('title', 'Add Chicken')

@section('content_header')
    <h1>Add Chicken</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            {{-- <i class="fas fa-10x fa-plus-circle"></i> --}}
            <h1 class="mt-5">Add New Chicken</h1>
            <form method="POST">
                {{-- action="{{ route('chickens.store') }}" --}}
                @csrf
                <div class="form-group">
                    <label for="breed">Breed</label>
                    <select name="breedid" class="form-control" id="breed" required>
                        @php
                            $breeds = [
                                ['breedid' => 1, 'name' => 'Rhode Island Red'],
                                ['breedid' => 2, 'name' => 'Leghorn'],
                                ['breedid' => 3, 'name' => 'Plymouth Rock'],
                            ];
                        @endphp
                        @foreach($breeds as $breed)
                            <option value="{{ $breed['breedid'] }}">{{ $breed['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" id="dob" required>
                </div>
                <div class="form-group">
                    <label for="cage">Cage</label>
                    <select name="cageid" class="form-control" id="cage" required>
                        @php
                            $cage = [
                                ['cageid' => 1, 'name' => 'Cage No 1'],
                                ['cageid' => 2, 'name' => 'Cage No 2'],
                                ['cageid' => 3, 'name' => 'Cage No 3'],
                            ];
                        @endphp
                        @foreach($cage as $cage)
                            <option value="{{ $cage['cageid'] }}">{{ $cage['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="qty">Quantity</label>
                    <input type="number" name="quantity" class="form-control" id="qty" required>
                </div>
                <button type="submit" class="btn btn-success float-right">Add Chicken</button>
            </form>
        </div>
    </div>
</div>
@stop
