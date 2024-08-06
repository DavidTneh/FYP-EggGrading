@extends('/admin')

@section('title', 'Confirm Deletion')

@section('content_header')
    <h1>Confirm Deletion</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            
            <h1 class="mt-5">Confirm Deletion <i class="fas fa-exclamation-triangle"></i></h1>
            
            <div class="alert alert-danger">
                <strong>Warning!</strong> You are about to delete a chicken.
            </div>
            
            <table class="table">
                <tbody>
                    <!-- Hard-coded values -->
                    <tr>
                        <th>Chicken ID</th>
                        <td>1</td>
                    </tr>
                    <tr>
                        <th>Breed</th>
                        <td>Rhode Island Red</td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td>2023-01-15</td>
                    </tr>
                    <tr>
                        <th>Cage ID</th>
                        <td>1</td>
                    </tr>
                </tbody>
            </table>
            
           <!-- Delete Confirmation Form -->
           <form method="POST" action="#">
            @csrf
            @method('DELETE')
            <div class="mt-3 float-right">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this chicken?')">Delete Chicken</button>
                <a href="#" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
</div>
@stop