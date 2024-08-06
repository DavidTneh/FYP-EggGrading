<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <div class="card w-100" style="max-width: 900px; border-radius: 15px;">
            <div class="row g-0">
                <!-- Blue Section (Left Column) -->
                <div class="col-md-6 d-flex flex-column align-items-center justify-content-center text-center bg-primary-custom text-white" style="border-top-left-radius: 15px; border-bottom-left-radius: 15px;">
                    <i class="fas fa-8x fa-egg"></i>
                    <h1 class="h4 mb-3">Efficiently Manage Your Poultry Egg Production.</h1>
                    <p>Access powerful tools for grading and managing your egg production process.</p>
                </div>

                <!-- Login Form Section (Right Column) -->
                <div class="col-md-6 p-5">
                    <h2 class="h5 text-center mb-4">Login</h2>
                    <form method="POST">
                        {{-- action="{{ route('login') }}" --}}
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style="background-color: #007bff; border: none;">Login</button>
                    </form>
                    <div class="mt-3 text-center">
                        <p class="mb-0">Don't have an account? <a href="#" class="text-primary-custom">Register</a></p>
                        {{-- href="{{ route('register') }}" --}}
                    </div>
                    <div class="mt-2 text-center">
                        <a href="#" class="text-primary-custom">Forgot your password?</a>
                        {{-- href="{{ route('password.request') }}" --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
