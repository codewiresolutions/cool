<?php

namespace App\Http\Controllers;

use App\Package;
use App\Traits\CompanyPackageTrait;
use App\Traits\JobSeekerPackageTrait;
use Auth;
use Config;
use Exception;
use Illuminate\Http\Request;
use Input;
use PDF;
use Redirect;
use Stripe\Charge;
use Stripe\Stripe;

/** All Stripe Details class * */
class StripeOrderController extends Controller
{

    use CompanyPackageTrait;
    use JobSeekerPackageTrait;

    private $redirectTo = 'home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*         * ****************************************** */
        // $this->middleware(function ($request, $next) {
        //     if (Auth::guard('company')->check()) {
        //         $this->redirectTo = 'company.home';
        //     }
        //     return $next($request);
        // });
        $this->middleware(function ($request, $next) {
            if (Auth::guard('company')->check()) {
                $this->redirectTo = 'company.home';
                return $next($request);
            } elseif (Auth::guard('web')->check()) {
                $this->redirectTo = 'home';
                return $next($request);
            } else {
                return redirect(route('login'));
            }
        });
        /*         * ****************************************** */
    }

    public function stripeOrderForm(Request $request, $package_id, $new_or_upgrade)
    {
        $package = Package::findOrFail($package_id);

        if ($package->package_for === 'employer') {
            if (!Auth::guard('company')->check()) {
                return redirect()->route('packages')
                    ->with('error', 'You are not allowed to purchase this package.');
            }
        } elseif ($package->package_for === 'job_seeker') {
            if (!Auth::guard('web')->check()) {
                return redirect()->route('packages')
                    ->with('error', 'You are not allowed to purchase this package.');
            }
        } else {
            return redirect()->route('packages')
                ->with('error', 'Invalid package type.');
        }

        if (Auth::guard('company')->check()) {
            $company = Auth::guard('company')->user()->company;
            $current_pckg_end_date = $company->package_end_date;
        }

        if (Auth::check()) {
            $current_pckg_end_date = Auth::user()->package_end_date;
        }

        if ($new_or_upgrade == 'upgrade' && $package->package_price == 0) {

            $today_date = date('Y-m-d');

            if ($current_pckg_end_date > $today_date) {
                flash(__('You have already subscribed to a package'));
                return Redirect::route($this->redirectTo);
            }
        }

        return view('order.pay_with_stripe', [
            'package' => $package,
            'package_id' => $package_id,
            'new_or_upgrade' => $new_or_upgrade,
        ]);
    }


    public function stripeOrderPackage(Request $request)
    {
        $package = Package::findOrFail($request->package_id);

        $order_amount = $package->package_price;

        /* ************************ */
        $buyer_id = '';
        $buyer_name = '';
        if (Auth::guard('company')->check()) {
            $buyer_id = Auth::guard('company')->user()->company->id;
            $buyer_name = Auth::guard('company')->user()->company->name . '(' . Auth::guard('company')->user()->company->email . ')';
        }
        if (Auth::check()) {
            $buyer_id = Auth::user()->id;
            $buyer_name = Auth::user()->getName() . '(' . Auth::user()->email . ')';
        }
        $package_for = ($package->package_for == 'employer') ? __('Employer') : __('Job Seeker');
        $description = $package_for . ' ' . $buyer_name . ' - ' . $buyer_id . ' ' . __('Package') . ':' . $package->package_title;
        /* ************************ */
        Stripe::setApiKey(Config::get('stripe.stripe_secret'));
        try {
            $charge = Charge::create([
                "amount" => $order_amount * 100,
                "currency" => "USD",
                "source" => $request->input('stripeToken'), // obtained with Stripe.js
                "description" => $description,
            ]);
            if ($charge['status'] == 'succeeded') {
                if (Auth::guard('company')->check()) {
                    $company = Auth::guard('company')->user()->company;
                    $this->addCompanyPackage($company, $package, 'Stripe');
                }
                if (Auth::check()) {
                    $user = Auth::user();
                    $user->transaction = $charge['balance_transaction'];
                    $user->update();
                    $this->addJobSeekerPackage($user, $package);
                }

                // Redirect to the "invoice" route with the package details
                flash(__('You have successfully subscribed to selected package'))->success();
                //  return redirect()->route('invoice', ['id' => $package->id]);
                return Redirect::route($this->redirectTo);
            } else {
                flash(__('Package subscription failed'));
                return redirect()->route($this->redirectTo);
            }
        } catch (Exception $e) {
            flash($e->getMessage());
            return redirect()->route($this->redirectTo);
        }
    }


    public function getInvoice($package_id)
    {
        $package = Package::findOrFail($package_id);
        if (auth()->user()->id) {
            $user = Auth::user();
            if ($user->package_id != NULL) {
                // $sub_package = Package::findOrFail($user->package_id);
                // if (
                //     ($user->package_end_date != null) &&
                //     ($user->package_end_date->gt(Carbon::now()))
                // ) {
                //     flash(__('You are already Subscribed to '.$sub_package->package_title).' package')->success();
                //     return \Redirect::route('home');
                //     exit;
                // }
            }
        }
        return view('order.invoice')
            ->with('package', $package)
            ->with('package_id', $package_id)
            ->with('user', $user);
    }

    function download($package_id)
    {
        $package = Package::findOrFail($package_id);

        // Load the PDF view and pass the package data
        $pdf = PDF::loadView('order.download', compact('package'));

        // Generate a unique filename for the PDF
        $filename = 'invoice_' . $package_id . '.pdf';

        // Download the PDF with a specific filename
        return $pdf->download($filename);
    }

    public function StripeOrderUpgradePackage(Request $request)
    {
        $package = Package::findOrFail($request->package_id);

        $order_amount = $package->package_price;

        /*         * ************************ */
        $buyer_id = '';
        $buyer_name = '';
        if (Auth::guard('company')->check()) {
            $buyer_id = Auth::guard('company')->user()->company->id;
            $buyer_name = Auth::guard('company')->user()->company->name . '(' . Auth::guard('company')->user()->company->email . ')';
        }
        if (Auth::check()) {
            $buyer_id = Auth::user()->id;
            $buyer_name = Auth::user()->getName() . '(' . Auth::user()->email . ')';
        }
        /*         * ************************* */

        $package_for = ($package->package_for == 'employer') ? __('Employer') : __('Job Seeker');
        $description = $package_for . ' ' . $buyer_name . ' - ' . $buyer_id . ' ' . __('Upgrade Package') . ':' . $package->package_title;
        /*         * ************************ */
        Stripe::setApiKey(Config::get('stripe.stripe_secret'));
        try {
            $charge = Charge::create(array(
                "amount" => $order_amount * 100,
                "currency" => "USD",
                "source" => $request->input('stripeToken'), // obtained with Stripe.js
                "description" => $description
            ));
            if ($charge['status'] == 'succeeded') {
                /**
                 * Write Here Your Database insert logic.
                 */
                if (Auth::guard('company')->check()) {
                    $company = Auth::guard('company')->user()->company;
                    $this->updateCompanyPackage($company, $package, 'Stripe');
                }
                if (Auth::check()) {
                    $user = Auth::user();
                    $user->transaction = $charge['balance_transaction'];
                    $user->update();
                    $this->updateJobSeekerPackage($user, $package, 'Stripe');
                }
                flash(__('You have successfully subscribed to selected package'))->success();
                // return redirect()->route('invoice', ['id' => $package->id]);
                return Redirect::route($this->redirectTo);
            } else {
                flash(__('Package subscription failed'));
                return Redirect::route($this->redirectTo);
            }
        } catch (Exception $e) {
            flash($e->getMessage());
            return Redirect::route($this->redirectTo);
        }
    }

}
