@extends('layouts.app')

@section('content')
    @include('includes.header')

    @include('includes.inner_page_title', ['page_title' => __('Company Account')])

    <div class="listpgWraper messageWrap">
        <div class="container">
            <div class="row">
                @include('includes.company_dashboard_menu')
                <!-- Content start -->
                <div class="col-md-9 col-sm-8">
                    <div class="userccount">
                        <h5>{{ __('Account Information') }}</h5>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="formrow">
                                    <label for="email">{{ __('Email') }}</label>
                                    <p id="email" class="form-control-plaintext text-start">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="formpanel mt0">
                            @include('flash::message')

                            <h5 class="mb-3">{{ __('Change Password') }}</h5>

                            <form method="POST" action="{{ route('change-password.company') }}">
                                @csrf

                                <div class="form-group mb-3">
                                    <label for="current_password">{{ __('Current Password') }}</label>
                                    <input type="password" name="current_password" id="current_password"
                                           class="form-control" required>
                                    @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="new_password">{{ __('New Password') }}</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control"
                                           required>
                                    @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="new_password_confirmation">{{ __('Confirm New Password') }}</label>
                                    <input type="password" name="new_password_confirmation"
                                           id="new_password_confirmation" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Password') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style type="text/css">
        .userccount p {
            text-align: left !important;
        }
    </style>
@endpush
