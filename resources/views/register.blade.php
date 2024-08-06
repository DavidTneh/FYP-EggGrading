<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
                <!-- Blue Section (Left Column) -->
                <div class="col-md-4 d-flex flex-column align-items-center justify-content-center text-center bg-primary-custom text-white" style="border-top-left-radius: 15px; border-bottom-left-radius: 15px;">
                    <i class="fas fa-8x fa-egg"></i>
                    <h1 class="h4 mb-3">Optimizing Poultry Egg Production and Quality.</h1>
                    <p>Streamline your egg production process with advanced grading and management tools.</p>
                    
                </div>

                <!-- Form Section (Right Column) -->
                <div class="col-md-8 p-5">
                    <h2 class="h5 text-center mb-4">Registration</h2>
                    <form method="POST">
                        {{-- action="{{ route('register') }}" --}}
                        @csrf

                        <div class="row">
                            <!-- First Column Fields -->
                            <div class="col-md-6">
                                <fieldset>
                                    <legend class="h6 mb-3">Basic Information</legend>
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                </fieldset>
                            </div>

                            <!-- Second Column Fields -->
                            <div class="col-md-6">
                                <fieldset>
                                    <legend class="h6 mb-3">Additional Information</legend>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="dob" name="dob" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">I agree to the <a href="#" class="text-primary-custom">terms and conditions</a></label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style="background-color: #007bff; border: none;">Sign Up</button>
                    </form>
                    <div class="mt-3 text-center">
                        <p class="mb-0">Already have an account? <a href="#" class="text-primary-custom">Sign in</a></p>
                        {{-- href="{{ route('login') }}" --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
