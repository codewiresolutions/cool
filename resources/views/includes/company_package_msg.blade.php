<div class="instoretxt">
    <div class="credit">
        {{ __('Your Package is') }}:
        <strong>
            {{ $package->package_title }}
            @if($package->package_price > 0)
                - {{ $siteSetting->default_currency_code }} {{ $package->package_price }}
            @endif
        </strong>
    </div>
    <div class="credit">{{__('Package Duration')}} :
        <strong>{{Auth::guard('company')->user()->company->package_start_date->format('d M, Y')}}</strong> -
        <strong>{{Auth::guard('company')->user()->company->package_end_date->format('d M, Y')}}</strong></div>
    <div class="row">
        <div class="col-md-6 mb-4 text-center">
            <div id="donutchartCvs" style="width:100%; height:300px;"></div>
            <div class="mt-2">
                Total CVs Quota: {{ Auth::guard('company')->user()->company->cvs_quota ?? 0 }}
            </div>
        </div>
        
        <div class="col-md-6 mb-4 text-center">
            <div id="donutchartDownloads" style="width:100%; height:300px;"></div>
            <div class="mt-2">
                Total Download Resume Quota: {{ Auth::guard('company')->user()->company->download_resume_quota ?? 0 }}
            </div>
        </div>
        
        <div class="col-md-6 mb-4 text-center">
            <div id="donutchartJobs" style="width:100%; height:300px;"></div>
            <div class="mt-2">
                Total Jobs Quota: {{ Auth::guard('company')->user()->company->jobs_quota ?? 0 }}
            </div>
        </div>
        
        <div class="col-md-6 mb-4 text-center">
            <div id="donutchartUsers" style="width:100%; height:300px;"></div>
            <div class="mt-2">
                Total Users Quota: {{ Auth::guard('company')->user()->company->users_quota ?? 0 }}
            </div>
        </div>
    </div>
</div>
