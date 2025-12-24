@extends('layouts.app')

@section('content')
    @include('includes.header')

    <div class="pageTitle">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <h1 class="page-heading fw-bold text-uppercase">Accept Invitation</h1>
                    <p class="mb-0">Complete your registration to activate your account</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="listpgWraper py-5">
        <div class="container">
            @include('flash::message')

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-lg rounded-3 border-0">
                        <div class="card-body p-5">
                            <h4 class="mb-4 text-center text-primary fw-semibold">Activate Your Account</h4>

                            <form method="POST" action="{{ route('company-users.complete-invite', $invite->id) }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $invite->invite_token }}">

                                <!-- Name -->
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Full Name</label>
                                    <input type="text"
                                           name="name"
                                           value="{{ old('name', $invite->name) }}"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Enter your full name"
                                           required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Password</label>
                                    <input type="password"
                                           name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Enter a secure password"
                                           required>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Confirm Password</label>
                                    <input type="password"
                                           name="password_confirmation"
                                           class="form-control"
                                           placeholder="Re-enter your password"
                                           required>
                                </div>

                                <!-- Submit -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                        <i class="bi bi-check-circle me-2"></i> Activate Account
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <p class="text-center mt-4 text-muted">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-decoration-none">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @include('includes.footer')
@endsection
