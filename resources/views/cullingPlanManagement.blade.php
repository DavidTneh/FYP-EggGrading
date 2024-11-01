@extends('/admin')

@section('title', 'Culling Plans Management')

@section('content_header')
<h1>Culling Plans Management</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Culling Plans</h1>
            <a href="{{ route('cullingplan.create') }}" class="btn btn-success mb-3 float-right">Add New Culling
                Plan</a>

            <!-- Culling Plans List Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Eliminate Age Threshold (months)</th>
                        <th>Reasons</th>
                        <th>Health Status</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cullingPlans as $plan)
                    <tr>
                        <td>{{ $plan->cullingplanID }}</td>
                        <td>{{ $plan->eliminateAgeThreshold }} months</td>
                        <td>{{ $plan->reasons }}</td>
                        <td>{{ $plan->healthStatus }}</td>
                        <td>{{ $plan->notes }}</td>
                        <td>
                            <a href="{{ route('cullingplan.edit', $plan->cullingplanID) }}"
                                class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ route('cullingplan.delete', $plan->cullingplanID) }}"
                                class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <div class="mt-3">
                {{ $cullingPlans->links() }}
            </div>
        </div>
    </div>
</div>
@stop