@php use Carbon\Carbon; @endphp
@extends('layouts.app')
@section('content')
    @include('includes.header')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Page Title -->
    <div class="pageTitle">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    <h1 class="page-heading">Membership Plans</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <!-- Job Seeker Packages Section -->
        @if($packagesJobSeeker->isNotEmpty())
            <section class="mb-5">
                <h2 class="text-primary mb-4">Job Seeker Packages</h2>
                @empty($existingUserPackage && $user && Carbon::parse($user->package_end_date)->isFuture())
                    @include('includes.user_packages_new', ['packages' => $packagesJobSeeker])
                @else
                    @include('includes.user_packages_upgrade', ['packages' => $packagesJobSeeker])
                @endif
            </section>
        @endif
        
        <!-- Company Packages Section -->
        @if($packagesCompany->isNotEmpty())
            <section class="mb-5">
                <h2 class="text-primary mb-4">Employer Packages</h2>
                @include('includes.company_packages', ['packages' => $packagesCompany,'existing_package' => $existingCompanyPackage])
            </section>
        @endif
    </div>
@endsection
