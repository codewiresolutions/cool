@php use Carbon\Carbon; @endphp
@if($packages->count())
    <div class="paypackages">
        <div class="four-plan">
            <h3>
                @if(!empty($existing_package) && $company && Carbon::parse($company->package_end_date)->isFuture())
                    {{ __('Upgrade Package') }}
                @else
                    {{ __('Buy Package') }}
                @endif
            </h3>
            
            <div class="row">
                @foreach($packages as $package)
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <ul class="boxes">
                            <li class="plan-name">{{ $package->package_title }}</li>
                            <li>
                                <div class="main-plan">
                                    <div class="plan-price1-1">$</div>
                                    <div class="plan-price1-2">{{ $package->package_price }}</div>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            <li class="plan-pages">{{ __('Post jobs') }}: {{ $package->package_num_listings }}</li>
                            <li class="plan-pages">{{ __('Add users') }}: {{ $package->package_users_limit }}</li>
                            <li class="plan-pages">{{ __('Download resumes') }}
                                : {{ $package->package_resume_downloads }}</li>
                            <li class="plan-pages">{{ __('Search resumes') }}
                                : {{ $package->package_cv_searches }}</li>
                            <li class="plan-pages">{{ __('Package Duration') }}
                                : {{ $package->package_num_days }} {{ __('Days') }}</li>
                            @if($package->package_price > 0)
                                <li class="order">
                                    @if($existing_package && $company && Carbon::parse($company->package_end_date)->isFuture())
                                        {{-- Company already has a package → upgrade --}}
                                        <a href="{{route('stripe.order.form', [$package->id, 'upgrade'])}}"
                                           data-turbolinks="false">
                                            <i class="fa"
                                               aria-hidden="true"></i> {{ __('Buy Now') }}
                                        </a>
                                    @else
                                        {{-- First time purchase --}}
                                        <a href="{{route('stripe.order.form', [$package->id, 'new'])}}"
                                           data-turbolinks="false">
                                            <i class="fa"
                                               aria-hidden="true"></i> {{ __('Buy Now') }}
                                        </a>
                                    @endif
                                </li>
                            @else
                                <li class="order paypal">
                                    <a href="{{ route('order.free.package', $package->id) }}">
                                        {{ __('Subscribe Free Package') }}
                                    </a>
                                </li>
                            @endif
                            {{--                            <li class="order paypal">--}}
                            {{--                                <a href="javascript:void(0)" data-toggle="modal"--}}
                            {{--                                   data-target="#buypack{{ $package->id }}" class="reqbtn">--}}
                            {{--                                    {{ __('Buy Now') }}--}}
                            {{--                                </a>--}}
                            {{--                            </li>--}}
                        </ul>
                        {{--                        @include('company.packages.partials.payment-modal', ['package' => $package, 'existing_package' => $existing_package, 'company' => $company])--}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif



