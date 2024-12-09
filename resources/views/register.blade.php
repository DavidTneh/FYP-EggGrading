<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-primary-custom {
            background-color: #007bff;
        }

        .text-primary-custom {
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center" style="background-color: #f8f9fa;">
        <div class="card w-100" style="max-width: 1200px; border-radius: 15px;">
            <div class="row g-0">
                <div class="col-md-4 d-flex flex-column align-items-center justify-content-center text-center bg-primary-custom text-white"
                    style="border-top-left-radius: 15px; border-bottom-left-radius: 15px;">
                    <i class="fas fa-8x fa-egg"></i>
                    <h1 class="h4 mb-3">Optimizing Poultry Egg Production and Quality.</h1>
                    <p>Streamline your egg production process with advanced grading and management tools.</p>
                </div>

                <div class="col-md-8 p-5">
                    <h2 class="h5 text-center mb-4">Registration</h2>
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
                    <form method="POST" action="{{ route('admin.register.post') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phoneNo" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phoneNo" name="phoneNo"
                                        value="{{ old('phoneNo') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ old('address') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">I agree to the <a href="#"
                                    class="text-primary-custom">terms and conditions</a></label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style="background-color: #007bff;">Sign
                            Up</button>
                    </form>
                    <div class="mt-3 text-center">
                        <p>Already have an account? <a href="{{ route('admin.login') }}"
                                class="text-primary-custom">Sign in</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>