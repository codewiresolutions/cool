@extends('layouts.app')

@section('content')
    @include('includes.header')
    @include('includes.inner_page_title', ['page_title' => __('Company User')])
    
    <div class="listpgWraper">
        <div class="container">
            <div class="row">
                @include('includes.company_dashboard_menu')
                
                <!-- Content start -->
                <div class="col-md-9 col-sm-8">
                    <div class="userccount">
                        <h5 class="mb-4">{{ __('Create New Company User') }}</h5>
                        
                        <div class="formpanel">
                            @include('flash::message')
                            
                            <form method="POST" action="{{ route('company.users.store') }}">
                                @csrf
                                
                                <!-- Name -->
                                <div class="form-group mb-3">
                                    <label for="name">{{ __('Full Name') }}</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           value="{{ old('name') }}" required>
                                    @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <!-- Email -->
                                <div class="form-group mb-3">
                                    <label for="email">{{ __('Email Address') }}</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                           value="{{ old('email') }}" required>
                                    @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <!-- Submit -->
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-user-plus"></i> {{ __('Create User') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Content end -->
            </div>
        </div>
    </div>
@endsection
