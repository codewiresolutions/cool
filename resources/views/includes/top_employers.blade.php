<div class="section pt-0 pb-0">
    <div class="container-fluid pt-xs-0 pt-sm-0 pt-md-2 pl-xs-0 pl-sm-0 pl-md-4">
        <div class="row p-xs-0 p-sm-0 p-md-5" style="padding-top: 29px !important;">
            <div class="col-lg-12 p-4 company-marquee-wrapper">
                <div class="titleTop mb-3 text-center">
                    <h3 class="font-weight-bold" style="font-size: 1.8rem;">
                        {{ __('Featured') }} <span style="color: #007bff;">{{ __('Companies') }}</span>
                    </h3>
                </div>
                <div class="company-marquee-container">
                    <div class="company-marquee-track">
                        <div class="marquee-group">
                            @foreach($topCompanyIds as $company_id_num_jobs)
                                @php
                                    $company = App\Company::where('id', $company_id_num_jobs->company_id)->active()->first();
                                @endphp@if($company)
                                    <div class="company-logo">
                                        <a href="{{ route('company.detail', $company->slug) }}">
                                            {!! $company->printCompanyImage() !!}
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        <div class="marquee-group">
                            @foreach($topCompanyIds as $company_id_num_jobs)
                                @php
                                    $company = App\Company::where('id', $company_id_num_jobs->company_id)->active()->first();
                                @endphp
                                @if($company)
                                    <div class="company-logo">
                                        <a href="{{ route('company.detail', $company->slug) }}">
                                            {!! $company->printCompanyImage() !!}
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        <div class="marquee-group">
                            @foreach($topCompanyIds as $company_id_num_jobs)
                                @php
                                    $company = App\Company::where('id', $company_id_num_jobs->company_id)->active()->first();
                                @endphp
                                @if($company)
                                    <div class="company-logo">
                                        <a href="{{ route('company.detail', $company->slug) }}">
                                            {!! $company->printCompanyImage() !!}
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <button class="carousel-prev btn btn-primary">
                    <i class="fa fa-chevron-left"></i>
                </button>
                <button class="carousel-next btn btn-primary">
                    <i class="fa fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
