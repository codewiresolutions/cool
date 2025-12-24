<?php


namespace App\Traits;


use Carbon\Carbon;


trait CompanyPackageTrait
{
    public function addCompanyPackage($company, $package, $method = '')
    {
        $now = Carbon::now();

        // Assign new package
        $company->package_id = $package->id;

        $company->package_start_date = $now;
        $company->package_end_date = $now->copy()->addDays($package->package_num_days);

        // Update quotas
        $company->jobs_quota = $package->package_num_listings;
        $company->availed_jobs_quota = 0;

        $company->download_resume_quota = $package->package_resume_downloads;
        $company->availed_download_resume_quota = 0;

        $company->cvs_quota = $package->package_cv_searches;
        $company->availed_cvs_quota = 0;

        $company->users_quota = $package->package_users_limit;
        $company->availed_users_quota = 0;

        $company->payment_method = $method;
        $company->save();
    }

    public function updateCompanyPackage($company, $package, $method = '')
    {
        // Reset package period
        $company->package_start_date = now();
        $company->package_end_date = now()->addDays($package->package_num_days);

        // Assign new package
        $company->package_id = $package->id;

        // Accumulate quotas (leftover + new package quota)
        $remainingJobs = max(0, $company->jobs_quota - $company->availed_jobs_quota);
        $company->jobs_quota = $remainingJobs + $package->package_num_listings;
        $company->availed_jobs_quota = 0;

        $remainingDownloads = max(0, $company->download_resume_quota - $company->availed_download_resume_quota);
        $company->download_resume_quota = $remainingDownloads + $package->package_resume_downloads;
        $company->availed_download_resume_quota = 0;

        $remainingCvs = max(0, $company->cvs_quota - $company->availed_cvs_quota);
        $company->cvs_quota = $remainingCvs + $package->package_cv_searches;
        $company->availed_cvs_quota = 0;

        $remainingUsers = max(0, $company->users_quota - $company->availed_users_quota);
        $company->users_quota = $remainingUsers + $package->package_users_limit;
        $company->availed_users_quota = 0;
        
        $company->payment_method = $method;
        $company->save();
    }

}

