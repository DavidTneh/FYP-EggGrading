@extends('/admin')

@section('title', 'Update Chicken')

@section('content_header')
    <h1>Update Chicken</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
           
            <h1 class="mt-5">Update Chicken <i class="fas fa-edit"></i></h1>
            <form method="POST" action="#">
                @csrf
                @method('PUT')
                
                <!-- Hard-coded values -->
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
                            <option value="{{ $breed['breedid'] }}" {{ $breed['breedid'] == 1 ? 'selected' : '' }}>{{ $breed['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" id="dob" value="2023-01-15" required>
                </div>
                <div class="form-group">
                    <label for="cage">Cage ID</label>
                    <input type="number" name="cageid" class="form-control" id="cage" value="1" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" class="form-control" id="quantity" value="10" required>
                </div>
                <button type="submit" class="btn btn-success float-right">Update Chicken</button>
            </form>
        </div>
    </div>
</div>
@stop
