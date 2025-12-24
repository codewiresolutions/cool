@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    
    <!-- Header start -->
    
    @include('includes.header')
    <!--@include('includes.botman')-->
    
    <!-- Header end -->
    
    <!-- Inner Page Title start -->
    
    @include('includes.inner_page_title', ['page_title'=>__('Dashboard')])
    
    <!-- Inner Page Title end -->
    
    <div class="listpgWraper">
        <div class="container">@include('flash::message')
            <div class="row"> @include('includes.user_dashboard_menu')
                <div class="col-lg-9">
                    <div class="profileban">
                        <div class="abtuser">
                            <div class="row">
                                <div class="col-lg-2 col-md-2">
                                    <div class="uavatar">{{auth()->user()->printUserImage()}}</div>
                                </div>
                                <div class="col-lg-10 col-md-10">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <h4>{{auth()->user()->name}}</h4>
                                            <h6><i class="fa fa-map-marker"
                                                   aria-hidden="true"></i> {{Auth::user()->getLocation()}}</h6>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="editbtbn"><a href="{{ route('my.profile') }}"><i
                                                            class="fas fa-pencil-alt" aria-hidden="true"></i>
                                                    Profile</a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <ul class="row userdata">
                                        <li class="col-lg-6 col-md-6"><i class="fa fa-phone"
                                                                         aria-hidden="true"></i> {{auth()->user()->phone}}
                                        </li>
                                        
                                        <li class="col-lg-6 col-md-6"><i class="fa fa-envelope"
                                                                         aria-hidden="true"></i> {{auth()->user()->email}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('includes.user_dashboard_stats')
                    {{-- for admin purposes Que --}}
                    {{-- @if((bool)config('jobseeker.is_jobseeker_package_active')) --}}
                    @empty($package && $user && Carbon::parse($user->package_end_date)->isFuture())
                        @include('includes.user_packages_new', ['packages' => $packages])
                    @else
                        @include('includes.user_package_msg')
                        @include('includes.user_packages_upgrade', ['packages' => $packages])
                    @endif
                    {{-- @endif  --}}
                    
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="profbox">
                                <h3><i class="fa fa-black-tie" aria-hidden="true"></i> Recommended Jobs</h3>
                                <ul class="recomndjobs">
                                    @forelse($matchingJobs as $match)
                                        <li>
                                            <h4>
                                                <a href="{{ route('job.detail', [$match->slug]) }}">{{ $match->title }}</a>
                                            </h4>
                                            <p>{{ $match->company->name ?? '' }}</p>
                                        </li>
                                    @empty
                                        <li>{{ __('No recommended jobs available.') }}</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        
                        
                        <div class="col-lg-5">
                            <div class="profbox followbox">
                                <h3><i class="fa fa-users"></i> My Followings</h3>
                                <ul class="followinglist">
                                    @forelse($followers as $follow)
                                        @if($follow->company)
                                            <li>
                                                <span>{{ $follow->company->name }}</span>
                                                <p>{{ $follow->company->location }}</p>
                                                <a href="{{ route('company.detail', $follow->company->slug) }}">{{ __('View Details') }}</a>
                                            </li>
                                        @endif
                                    @empty
                                        <li>{{ __('You are not following any companies yet.') }}</li>
                                    @endforelse
                                </ul>
                                <div class="allbtn"><a href="{{route('my.followings')}}"><i class="fas fa-users"></i>
                                        View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection

@push('scripts')
    
    @include('includes.immediate_available_btn')

@endpush