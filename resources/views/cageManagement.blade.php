@extends('/admin')

@section('title', 'Cage Management')

@section('content_header')
<h1>Cage Management</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Cage Management</h1>

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

            <!-- Add New Cage Button -->
            <div class="mb-3 float-right">
                <a href="{{ route('cages.create') }}" class="btn btn-success">Add New Cage</a>
            </div>

            <!-- Cage List Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Size</th>
                        <th>Capacity</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cages as $cage)
                    <tr>
                        <td>{{ $cage->cageID }}</td>
                        <td>{{ $cage->size }}</td>
                        <td>{{ $cage->capacity }}</td>
                        <td>{{ $cage->type }}</td>
                        <td>{{ $cage->status }}</td>
                        <td>
                            <a href="{{ route('cages.edit', $cage->cageID) }}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ route('cages.showDelete', $cage->cageID) }}"
                                class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Controls -->
            {{ $cages->links() }}
        </div>
    </div>
</div>
@stop