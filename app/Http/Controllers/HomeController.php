<?php

namespace App\Http\Controllers;

use App\FavouriteCompany;
use App\Job;
use App\Package;
use App\Traits\Cron;
use Auth;
use Illuminate\View\View;

class HomeController extends Controller
{

    use Cron;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->runCheckPackageValidity();
    }

    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function index()
    {
        $user = auth()->user();

        // Matching jobs
        $matchingJobs = Job::where('functional_area_id', $user->industry_id)
            ->with('company')
            ->paginate(5);

        // Followers
        $followers = FavouriteCompany::where('user_id', $user->id)
            ->with(['company' => function ($query) {
                $query->where('is_active', 1);
            }])
            ->get();

        // Packages for job seeker
        $allPackages = Package::where('package_for', 'job_seeker')->get();
        $package = $user->getPackage();

        if ($package) {
            $packages = Package::where('package_for', 'job_seeker')
                //->where('id', '<>', $package->id) // Packages eligible for upgrade
                //->where('package_price', '>=', $package->package_price)
                ->get();
        } else {
            $packages = $allPackages;
        }

        $user = Auth::guard('web')->user();

        return view('home', compact('matchingJobs', 'followers', 'package', 'packages', 'user'));
    }

}
