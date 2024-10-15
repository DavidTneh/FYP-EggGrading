@extends('layout.guest')

@section('title', 'Login | Poultry Egg Production')

{{-- Custom styles for login page only --}}
@section('custom-styles')
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
@endsection

@section('content')
<div class="container vh-100 d-flex justify-content-center align-items-center" style="background-color: #f8f9fa;">
    <div class="card w-100" style="max-width: 900px; border-radius: 15px;">
        <div class="row g-0">
            <!-- Blue Section (Left Column) -->
            <div class="col-md-6 d-flex flex-column align-items-center justify-content-center text-center bg-primary-custom text-white"
                style="border-top-left-radius: 15px; border-bottom-left-radius: 15px;">
                <i class="fas fa-8x fa-egg mb-3"></i> <!-- Added margin for spacing -->
                <h1 class="h4 mb-3">Efficiently Manage Your Poultry Egg Production.</h1>
                <p>Access powerful tools for grading and managing your egg production process.</p>
            </div>

            <!-- Login Form Section (Right Column) -->
            <div class="col-md-6 p-5">
                <h2 class="h5 text-center mb-4">Login</h2>

                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (session('status'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                    {{ session('status') }}
                </div>
                @endif

                <form action="{{ route('admin.login.post') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"  value="john@example.com" required>
                            {{-- value="{{ old('email') }}" --}}
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div style="position:relative;">
                            <input class="form-control" type="password" id="password" name="password" required value="password">
                            <span class="toggle-password" onclick="togglePass()"
                                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                <i id="toggleIcon" class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"
                        style="background-color: #007bff; border: none;">Login</button>
                </form>
                <div class="mt-3 text-center">
                    {{-- href="{{ route('register') }}" --}}
                    <p class="mb-0">Don't have an account? <a class="text-primary-custom">Register</a></p>
                </div>
                <div class="mt-2 text-center">
                    <a href="{{ route('admin.forgot_password') }}" class="text-primary-custom">Forgot your password?</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePass() {
        var x = document.getElementById("password");
        var icon = document.getElementById("toggleIcon");
        if (x.type === "password") {
            x.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            x.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>

@endsection