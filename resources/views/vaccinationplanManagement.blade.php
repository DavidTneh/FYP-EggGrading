@extends('/admin')

@section('title', 'Vaccination Plans Management')

@section('content_header')
    <h1>Vaccination Plans Management</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            
            <h1 class="mt-5">Vaccination Plans <i class="fas fa-syringe"></i> </h1>

            <!-- Add New Vaccination Plan Button -->
            {{-- href="{{ route('vaccination-plans.create') }}"  --}}
            <div class="mb-3 float-right">
                <a class="btn btn-success">Add New Vaccination Plan</a>
            </div>

            <!-- Vaccination Plans List Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Plan ID</th>
                        <th>Vaccination Type</th>
                        <th>Vaccination per Chicken</th>
                        <th>Cage</th>
                        <th>Total Vaccinations Required</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $vaccinationTypes = [
                            ['id' => 1, 'vaccinename' => 'Vaccine A'],
                            ['id' => 2, 'vaccinename' => 'Vaccine B'],
                        ];

                        $vaccinationPlans = [
                            ['id' => 1, 'vaccinationtypeID' => 1, 'vaccinationperchicken' => 1, 'cage' => 1, 'totalvaccinationrequired' => 100],
                            ['id' => 2, 'vaccinationtypeID' => 2, 'vaccinationperchicken' => 2, 'cage' => 2, 'totalvaccinationrequired' => 200],
                            // Add more plans for pagination demonstration
                            ['id' => 3, 'vaccinationtypeID' => 1, 'vaccinationperchicken' => 1, 'cage' => 3, 'totalvaccinationrequired' => 150],
                            ['id' => 4, 'vaccinationtypeID' => 2, 'vaccinationperchicken' => 2, 'cage' => 4, 'totalvaccinationrequired' => 250],
                            // ... More items for paging demonstration
                        ];
                        $currentPage = 1;
                        $perPage = 2;
                        $total = count($vaccinationPlans);
                        $pagination = array_slice($vaccinationPlans, ($currentPage - 1) * $perPage, $perPage);
                    @endphp

                    @foreach($pagination as $plan)
                        <tr>
                            <td>{{ $plan['id'] }}</td>
                            <td>{{ collect($vaccinationTypes)->firstWhere('id', $plan['vaccinationtypeID'])['vaccinename'] ?? 'Unknown' }}</td>
                            <td>{{ $plan['vaccinationperchicken'] }}</td>
                            <td>{{ $plan['cage'] }}</td>
                            <td>{{ $plan['totalvaccinationrequired'] }}</td>
                            <td>
                                {{-- href="{{ route('vaccination-plans.edit', $plan['id']) }}" --}}
                                <a class="btn btn-primary btn-sm">Edit</a>
                                {{-- action="{{ route('vaccination-plans.destroy', $plan['id']) }}"  --}}
                                <form method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this plan?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <div class="mt-3">
                @php
                    $totalPages = ceil($total / $perPage);
                @endphp

                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        @if($currentPage > 1)
                            <li class="page-item">
                                {{-- href="{{ route('vaccination-plans.index', ['page' => $currentPage - 1]) }}" --}}
                                <a class="page-link"  aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        @endif

                        @for($i = 1; $i <= $totalPages; $i++)
                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                {{-- href="{{ route('vaccination-plans.index', ['page' => $i]) }}" --}}
                                <a class="page-link" >{{ $i }}</a>
                            </li>
                        @endfor

                        @if($currentPage < $totalPages)
                            <li class="page-item">
                                {{-- href="{{ route('vaccination-plans.index', ['page' => $currentPage + 1]) }}"  --}}
                                <a class="page-link" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@stop
