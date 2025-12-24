@extends('layouts.app')

@section('content')
    @include('includes.header')
    @include('includes.inner_page_title', ['page_title' => __('Company Users')])
    
    <div class="listpgWraper">
        <div class="container">
            <div class="row">
                @include('includes.company_dashboard_menu')
                
                <!-- Content start -->
                <div class="col-md-9 col-sm-8">
                    <div class="userccount">
                        @php
                            $usersQuota   = $company->users_quota ?? 0;
                            $availedUsers = $company->availed_users_quota ?? 0;
                            $remaining    = max($usersQuota - $availedUsers, 0);
                        @endphp
                        
                        <h5 class="mb-4">{{ __('Company Users') }}</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ __('Remaining:') }} <strong>{{ $remaining }}</strong></span>
                            <span>{{ __('Limit:') }} <strong>{{ $usersQuota }}</strong></span>
                        </div>
                        
                        @include('flash::message')
                        @if($remaining <= 0)
                            <div class="alert alert-danger mt-3">
                                <i class="fa fa-exclamation-circle"></i>
                                {{ __('You have reached the maximum number of users allowed by your package.') }}
                            </div>
                        @endif
                        
                        @if($companyUsers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Role') }}</th>
                                        <th>{{ __('Created At') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($companyUsers as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ ucfirst($user->role) }}</td>
                                            <td>{{ $user->created_at->format('d M Y') }}</td>
                                            <td>
                                                @if(empty($user->email_verified_at))
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @else
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(Auth::guard('company')->user()->id !== $user->id)
                                                    <a href="{{ route('company.users.edit', $user) }}"
                                                       class="btn btn-sm btn-warning">
                                                        <i class="fa fa-edit"></i> {{ __('Edit') }}
                                                    </a>
                                                    
                                                    <form action="{{ route('company.users.destroy', $user) }}"
                                                          method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('{{ __('Are you sure?') }}')">
                                                            <i class="fa fa-trash"></i> {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="mt-3">
                                {{ $companyUsers->links() }}
                            </div>
                        @else
                            <p class="text-muted">{{ __('No company users found.') }}</p>
                        @endif
                        
                        <!-- Button to create new -->
                        <a href="{{ $remaining > 0 ? route('company.users.create') : '#' }}"
                           class="btn btn-primary mt-3 {{ $remaining <= 0 ? 'disabled' : '' }}">
                            <i class="fa fa-user-plus"></i> {{ __('Create New User') }}
                        </a>
                    </div>
                </div>
                <!-- Content end -->
            </div>
        </div>
    </div>
@endsection
