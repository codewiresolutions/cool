@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Upgrade Package')])
    <!-- Inner Page Title end -->
    <?php $company = Auth::guard('company')->user()->company ?>
    <div class="listpgWraper">
        <div class="container">@include('flash::message')
            <div class="row"> @include('includes.company_dashboard_menu')
                <div class="col-md-9 col-sm-8">
                    @if(null!==($existing_package) && !empty($existing_package))
                        <div class="instoretxt">
                            <div class="credit">{{__('Your Package is')}}: <strong>{{$existing_package->package_title}}
                                    - {{ $siteSetting->default_currency_code }}{{$existing_package->package_price}}</strong>
                            </div>
                            <div class="credit">{{__('Package Duration')}} :
                                <strong>{{Carbon\Carbon::parse($company->package_start_date)->format('d M, Y')}}</strong>
                                -
                                <strong>{{Carbon\Carbon::parse($company->package_end_date)->format('d M, Y')}}</strong>
                            </div>
                        </div>
                    @endif
                    @include('includes.company_packages',[$existing_package])
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection
@push('scripts')
    @include('includes.immediate_available_btn')
@endpush