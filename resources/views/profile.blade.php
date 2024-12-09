@extends('/admin')

@section('title', 'Profile')

@section('content_header')
<h1>Employee Profile</h1>
@stop

@section('content')
<div class="container">
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

@if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
    <div class="row">
        
        <!-- Left column: Profile Picture & Basic Info -->
        <div class="col-md-4 mt-4">
            <div class="card">
                <div class="card-body text-center">
                    <form id="profilePictureForm" action="{{ route('profile.updatePicture') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="profile-user-img img-circle mx-auto mb-3"
                            style="width: 120px; height: 120px; background-color: #f0f0f0; border: 1px solid #ccc; overflow: hidden; cursor: pointer;"
                            onclick="document.getElementById('profilePictureInput').click();">
                            <!-- Display user image if available -->
                            <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('default/profile-picture.png') }}"
                                alt="User profile picture"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        </div>
                        <input type="file" name="image" id="profilePictureInput" style="display: none;" accept="image/*"
                            onchange="document.getElementById('profilePictureForm').submit();">
                    </form>
                    <h3 class="profile-username">{{ $user->name }}</h3>
                    <p class="text-muted">{{ $user->role->roleName ?? 'Employee' }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Phone</b> <a class="float-right">{{ $user->phoneNo }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Right column: Profile Details & Settings -->
        <div class="col-md-8 mt-4">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab">Details</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Details Section -->
                        <div class="active tab-pane" id="details">
                            <form action="{{ route('profile.update') }}" method="POST" class="form-horizontal">
                                @csrf
                                @method('POST')
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" class="form-control" id="inputName"
                                            value="{{ $user->name }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" class="form-control" id="inputEmail"
                                            value="{{ $user->email }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPhone" class="col-sm-3 col-form-label">Phone</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="phoneNo" class="form-control" id="inputPhone"
                                            value="{{ $user->phoneNo }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputDOB" class="col-sm-3 col-form-label">Date Of Birth</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="dob" class="form-control" id="inputDOB"
                                            value="{{ $user->dob }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputAddress" class="col-sm-3 col-form-label">Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="address" class="form-control" id="inputAddress"
                                            value="{{ $user->address }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                        <button type="button" class="btn btn-primary" id="editBtn"
                                            onclick="toggleEdit()">Edit</button>
                                        <button type="submit" class="btn btn-success d-none" id="saveBtn">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Settings Section -->
                        <div class="tab-pane" id="settings">
                            <h4>Change Password</h4>

                            <!-- Notifications -->
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            @endif

                            <!-- Change Password Form -->
                            <form action="{{ route('profile.changePassword') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="currentPassword">Current Password</label>
                                    <input type="password" name="currentPassword" id="currentPassword"
                                        class="form-control" required>
                                    @error('currentPassword')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="newPassword">New Password</label>
                                    <input type="password" name="newPassword" id="newPassword" class="form-control"
                                        required>
                                    @error('newPassword')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="newPassword_confirmation">Confirm New Password</label>
                                    <input type="password" name="newPassword_confirmation" id="newPassword_confirmation"
                                        class="form-control" required>
                                    @error('newPassword_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Change Password</button>
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
        var inputs = document.querySelectorAll('#details input:not(#inputDOB)');
        var editBtn = document.getElementById('editBtn');
        var saveBtn = document.getElementById('saveBtn');

        inputs.forEach(input => {
            if (input.hasAttribute('readonly')) {
                input.removeAttribute('readonly');
            } else {
                input.setAttribute('readonly', 'readonly');
            }
        });

        // Toggle the visibility of the Edit and Save buttons
        editBtn.classList.toggle('d-none');
        saveBtn.classList.toggle('d-none');
    }
</script>
@stop