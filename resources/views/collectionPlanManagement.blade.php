@extends('/admin')

@section('title', 'Collection Plans Management')

@section('content_header')
<h1>Collection Plans Management</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Collection Plans</h1>
            <a href="{{ route('collectionplan.create') }}" class="btn btn-success mb-3 float-right">Add New Collection
                Plan</a>

            <!-- Collection Plans List Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Time</th>
                        <th>Frequency</th>
                        <th>Repeat</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($collectionPlans as $plan)
                    <tr>
                        <td>{{ $plan->collectionplanID }}</td>
                        <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $plan->time)->format('h:i A') }}</td>
                        <td>{{ $plan->frequency }}</td>
                        <td>{{ $plan->is_repeating ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('collectionplan.edit', $plan->collectionplanID) }}"
                                class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ route('collectionplan.delete', $plan->collectionplanID) }}"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this collection plan?')">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <div class="mt-3">
                {{ $collectionPlans->links() }}
            </div>
        </div>
    </div>
</div>
@stop