@extends('/admin')

@section('title', 'Feeding Plans Management')

@section('content_header')
<h1>Feeding Plans Management</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Feeding Plans</h1>
            <a href="{{ route('feedingplan.create') }}" class="btn btn-success mb-3 float-right">Add New Feeding
                Plan</a>

            <!-- Feeding Plans List Table -->
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
                    @foreach($feedingPlans as $plan)
                    <tr>
                        <td>{{ $plan->feedingplanID }}</td>
                        <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $plan->time)->format('h:i A') }}</td>
                        <td>{{ $plan->frequency }}</td>
                        <td>{{ $plan->repeat ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('feedingplan.edit', $plan->feedingplanID) }}"
                                class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ route('feedingplan.delete', $plan->feedingplanID) }}"
                                class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <div class="mt-3">
                {{ $feedingPlans->links() }}
            </div>
        </div>
    </div>
</div>
@stop