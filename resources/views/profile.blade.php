@extends('/admin')

@section('title', 'Profile')

@section('content_header')
    <h1>Employee Profile</h1>
@stop

@section('content')
<div class="container">
    <div class="row">
        <!-- Left column: Profile Picture & Basic Info -->
        <div class="col-md-4 mt-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="profile-user-img img-circle mx-auto mb-3"
                         style="width: 120px; height: 120px; background-color: #f0f0f0; border: 1px solid #ccc; overflow: hidden;">
                        <!-- Display user image if available -->
                        @if(isset($user->profile_picture) && $user->profile_picture)
                        <img src="{{ asset($user->profile_picture) }}" alt="User profile picture" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    @else
                        <!-- Placeholder image when no user image is available -->
                        <img src="{{ asset('dist/img/user3-128x128.jpg') }}" alt="Default user profile picture" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    @endif
                    </div>
                    <h3 class="profile-username">John Doe</h3>
                    <p class="text-muted">Admin</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-right">john.doe@example.com</a>
                    </li>
                    <li class="list-group-item">
                        <b>Phone</b> <a class="float-right">+123 456 7890</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Right column: Profile Details & Settings -->
        <div class="col-md-8 mt-4">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab">Details</a></li>
                        <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="details">
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputName" value="John Doe" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="inputEmail" value="john.doe@example.com" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPhone" class="col-sm-3 col-form-label">Phone</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputPhone" value="+123 456 7890" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputDOB" class="col-sm-3 col-form-label">Date Of Birth</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputDOB" value="1985-06-15" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputAddress" class="col-sm-3 col-form-label">Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputAddress" value="123 Main St, Springfield, IL" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                        <button type="button" class="btn btn-primary" id="editBtn" onclick="toggleEdit()">Edit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="settings">
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label for="currentPassword" class="col-sm-3 col-form-label">Current Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="currentPassword" placeholder="Current Password" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="newPassword" class="col-sm-3 col-form-label">New Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="newPassword" placeholder="New Password" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="confirmPassword" class="col-sm-3 col-form-label">Confirm Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                        <button type="button" class="btn btn-danger" onclick="toggleEdit()">Change Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleEdit() {
    var inputs = document.querySelectorAll('#details input');
    var editBtn = document.getElementById('editBtn');
    
    inputs.forEach(input => {
        if (input.hasAttribute('readonly')) {
            input.removeAttribute('readonly');
            editBtn.textContent = 'Save';
        } else {
            input.setAttribute('readonly', 'readonly');
            editBtn.textContent = 'Edit';
        }
    });
}
</script>
@stop
