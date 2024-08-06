@extends('/admin')

@section('content')
<div class="container mt-5">
    <div class="row g-4">
        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card mb-3" style="height: 150px;"> <!-- Adjust height as needed -->
                <div class="row g-0 h-100">
                    <div class="col-md-4 d-flex align-items-center justify-content-center" style="background-color:#34eb61;">
                        <i class="fas fa-5x fa-egg"></i>
                    </div>
                    <div class="col-md-8 d-flex flex-column">
                        <div class="card-body flex-fill">
                            <h5 class="card-title">Total Egg Today: 1000</h5>
                            
                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4">
            <div class="card mb-3" style="height: 150px;"> <!-- Adjust height as needed -->
                <div class="row g-0 h-100">
                    <div class="col-md-4 d-flex align-items-center justify-content-center" style="background-color:#34d5eb;">
                        <i class="fas fa-5x fa-list-ul"></i>
                    </div>
                    <div class="col-md-8 d-flex flex-column">
                        <div class="card-body flex-fill">
                            <h5 class="card-title">Pending Task: 5</h5>
                            
                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4">
            <div class="card mb-3" style="height: 150px;"> <!-- Adjust height as needed -->
                <div class="row g-0 h-100">
                    <div class="col-md-4 d-flex align-items-center justify-content-center" style="background-color:#eb346b;">

                        <i class="fas fa-5x fa-drumstick-bite"></i>
                    </div>
                    <div class="col-md-8 d-flex flex-column">
                        <div class="card-body flex-fill">
                            <h5 class="card-title">Total Chicken: 500</h5>
                            
                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
<div class="mb-4">
    <h4>Select Report</h4>
    <select class="form-select" aria-label="Select Report">
        <option selected>Select a report</option>
        <option value="1">Summary Report</option>
        <option value="2">Details Report</option>
        <option value="3">Exception Report</option>
    </select>
    <button type="submit" class="btn btn-success">View</button>
</div>  
</div>
@endsection
