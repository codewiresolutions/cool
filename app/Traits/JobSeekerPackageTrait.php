<?php

namespace App\Traits;

use Carbon\Carbon;

trait JobSeekerPackageTrait
{

    public function addJobSeekerPackage($user, $package)
    {
        $now = Carbon::now();
        $user->package_id = $package->id;
        $user->package_start_date = $now;
        $user->package_end_date = $now->addDays($package->package_num_days);
        $user->jobs_quota = $package->package_num_listings;
        $user->availed_jobs_quota = 0;
        $user->update();
    }

    public function updateJobSeekerPackage($user, $package)
    {
        // Reset package period
        $user->package_start_date = now();
        $user->package_end_date = now()->addDays($package->package_num_days);

        // Assign new package
        $user->package_id = $package->id;

        // Accumulate quotas (leftover + new package quota)
        $remainingJobs = max(0, $user->jobs_quota - $user->availed_jobs_quota);
        $user->jobs_quota = $remainingJobs + $package->package_num_listings;
        $user->availed_jobs_quota = 0;
        $user->save();
    }

}
