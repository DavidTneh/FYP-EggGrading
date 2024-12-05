@extends('admin')

@section('content')
<div class="container">
    <h1>Chicken Management</h1>
    <a href="{{ route('chickens.create') }}" class="btn btn-success mb-3">Add New Chicken</a>

    @foreach($chickensGrouped->groupBy('cageID') as $cageID => $cageGroups)
    <h3>Cage: {{ $cageGroups->first()->cage->name ?? 'Unknown Cage' }}</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Breed</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cageGroups as $group)
            <tr> 
                <td>{{ $group->breed->name }}</td>
                <td>{{ $group->quantity }}</td>
                <td>
                    <a href="{{ route('chickens.showGrouped', ['cageID' => $group->cageID, 'breedID' => $group->breedID]) }}" class="btn btn-info btn-sm">View</a>
                    
                        
                    <form action="{{ route('chickens.editGroup') }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="cageID" value="{{ $group->cageID }}">
                                            <input type="hidden" name="breedID" value="{{ $group->breedID }}">
                                            <button type="submit" class="btn btn-primary btn-sm">Edit Group</button>
                                        </form>

                    <form action="{{ route('chickens.destroyGrouped') }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="cageID" value="{{ $group->cageID }}">
                        <input type="hidden" name="breedID" value="{{ $group->breedID }}">
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this group?')">Delete
                            Group</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table> 
    @endforeach
</div>
@stop