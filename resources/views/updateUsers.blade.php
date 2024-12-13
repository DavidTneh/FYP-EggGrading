@extends('/admin')

@section('title', 'Edit Users')

@section('content_header')
<h1>Edit Users</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1>Edit Users</h1>
            @if ($errors->any())
            <div class="alert alert-danger">
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
            <form id="editUserForm" method="POST" action="{{ route('users.update') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="userID" value="{{ $user->userID }}">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" required>
                    <small class="text-danger" id="nameError"></small>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}"
                        required>
                    <small class="text-danger" id="emailError"></small>
                </div>
                <div class="form-group">
                    <label for="phoneNo">Phone No</label>
                    <input type="text" name="phoneNo" class="form-control" id="phoneNo" value="{{ $user->phoneNo }}">
                    <small class="text-danger" id="phoneNoError"></small>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="roleID" class="form-control" id="roleID">
                        @foreach($roles as $role)
                        <option value="{{ $role->roleID }}" {{ $role->roleID == $user->roleID ? 'selected' : '' }}>
                            {{ $role->roleName }}
                        </option>
                        @endforeach
                    </select>
                    <small class="text-danger" id="roleError"></small>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control" id="address" value="{{ $user->address }}">
                    <small class="text-danger" id="addressError"></small>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('editUserForm').addEventListener('submit', function(event) {
        let hasErrors = false;

        // Clear previous errors
        document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');

        // Name validation
        const name = document.getElementById('name').value.trim();
        if (name === '') {
            document.getElementById('nameError').textContent = 'Name is required.';
            hasErrors = true;
        } else if (name.length > 255) {
            document.getElementById('nameError').textContent = 'Name must not exceed 255 characters.';
            hasErrors = true;
        }

        // Email validation
        const email = document.getElementById('email').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === '') {
            document.getElementById('emailError').textContent = 'Email is required.';
            hasErrors = true;
        } else if (!emailRegex.test(email)) {
            document.getElementById('emailError').textContent = 'Please enter a valid email address.';
            hasErrors = true;
        }

        // Phone number validation
        const phoneNo = document.getElementById('phoneNo').value.trim();
        const phoneRegex = /^01\d{1}-?\d{7,8}$/; // Malaysia phone number format
        if (phoneNo !== '' && !phoneRegex.test(phoneNo)) {
            document.getElementById('phoneNoError').textContent = 'Phone number must follow the format 012-3456789 or 01134567890.';
            hasErrors = true;
        }

        // Role validation
        const roleID = document.getElementById('roleID').value.trim();
        if (roleID === '') {
            document.getElementById('roleError').textContent = 'Please select a role.';
            hasErrors = true;
        }

        // Address validation
        const address = document.getElementById('address').value.trim();
        if (address.length > 255) {
            document.getElementById('addressError').textContent = 'Address must not exceed 255 characters.';
            hasErrors = true;
        }

        // Prevent form submission if there are validation errors
        if (hasErrors) {
            event.preventDefault();
        }
    });
</script>
@stop