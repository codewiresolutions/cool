<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function index()
    {
        $packagesJobSeeker = collect();
        $packagesCompany = collect();

        $user = null;
        $existingUserPackage = null;

        $company = null;
        $existingCompanyPackage = null;

        // ===== Check guards =====
        if (Auth::guard('company')->check()) {
            $company = Auth::guard('company')->user()->company;
            $existingCompanyPackage = $company->getPackage();

            // Only show packages for employers
            $query = Package::where('package_for', 'employer');
            if ($existingCompanyPackage) {
                $query->where('package_price', '>', 0); // hide free if already subscribed
            }
            $packagesCompany = $query->get();

        } elseif (Auth::check()) {
            $user = Auth::user();
            $existingUserPackage = $user->getPackage();

            // Only show packages for job seekers
            $query = Package::where('package_for', 'job_seeker');
            if ($existingUserPackage) {
                $query->where('package_price', '>', 0);
            }
            $packagesJobSeeker = $query->get();
        } else {
            // Guest
            $packagesJobSeeker = Package::where('package_for', 'job_seeker')->orderBy('package_sequence')->get();
            $packagesCompany = Package::where('package_for', 'employer')->orderBy('package_sequence')->get();
        }

        return view('packages', compact(
            'packagesJobSeeker',
            'packagesCompany',
            'existingUserPackage',
            'existingCompanyPackage',
            'user',
            'company'
        ));
    }
}

