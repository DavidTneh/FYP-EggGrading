@extends('admin')

@section('content')
<div class="container">
    <h1>Add New Chicken</h1>
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <h5><i class="icon fas fa-ban"></i> Error!</h5>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('status'))
    <div class="alert alert-success alert-dismissible">
        <h5><i class="icon fas fa-check"></i> Success!</h5>
        {{ session('status') }}
    </div>
    @endif
    <form method="POST" action="{{ route('chickens.store') }}">
        @csrf
        <div class="form-group">
            <label for="breed">Breed</label>
            <select name="breedid" class="form-control" required>
                @foreach($breeds as $breed)
                <option value="{{ $breed->breedID }}">{{ $breed->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="cage">Cage</label>
            <select name="cageid" class="form-control" required>
                @foreach($cages as $cage)
                <option value="{{ $cage->cageID }}">{{ $cage->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="qty">Quantity</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Chicken</button>
    </form>
</div>
@stop