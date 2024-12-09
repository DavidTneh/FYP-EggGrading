@extends('/admin')

@section('title', 'Vaccination Plans Management')

@section('content_header')
<h1>Vaccination Plans Management</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Vaccination Plans <i class="fas fa-syringe"></i></h1>

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

            <div class="mb-3 float-right">
                <a href="{{ route('vaccinationplan.create') }}" class="btn btn-success">Add New Vaccination Plan</a>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Plan ID</th>
                        <th>Vaccination Type</th>
                        <th>Vaccination per Chicken</th>
                        <th>Age(In Days)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vaccinationPlans as $plan)
                    <tr>
                        <td>{{ $plan->vaccinationplanID }}</td>
                        <td>{{ $plan->vaccinationtype->vaccineName ?? 'N/A' }}</td>
                        <td>{{ $plan->vaccinationPerChicken }}</td>
                        <td>{{ $plan->ageThreshold }}</td>
                        <td>
                            <a href="{{ route('vaccinationplan.edit', $plan->vaccinationplanID) }}"
                                class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ route('vaccinationplan.delete', $plan->vaccinationplanID) }}"
                                class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                {{ $vaccinationPlans->links() }}
            </div>
        </div>
    </div>
</div>
@stop