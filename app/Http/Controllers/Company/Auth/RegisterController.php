<?php

namespace App\Http\Controllers\Company\Auth;

use App\Company;
use App\Events\CompanyRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\CompanyFrontRegisterFormRequest;
use App\Models\CompanyUser;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Jrean\UserVerification\Facades\UserVerification;
use Jrean\UserVerification\Traits\VerifiesUsers;

class RegisterController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

    use RegistersUsers;
    use VerifiesUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/company-home';
    protected $userTable = 'company_users';
    protected $redirectIfVerified = '/company-home';
    protected $redirectAfterVerification = '/company-home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('company.guest', ['except' => ['getVerification', 'getVerificationError']]);
    }

    public function register(CompanyFrontRegisterFormRequest $request)
    {
        $company = new Company();
        $company->name = $request->input('name');
        $company->is_active = 0;
        $company->email = $request->input('email');
        $company->verified = 0;
        $company->save();

        $company->slug = Str::slug($company->name, '-') . '-' . $company->id;
        $company->save();

        $companyUser = new CompanyUser();
        $companyUser->company_id = $company->id;
        $companyUser->name = $request->input('name');
        $companyUser->email = $request->input('email');
        $companyUser->password = bcrypt($request->input('password'));
        $companyUser->role = 'admin';
        $companyUser->is_active = 0;
        $companyUser->save();


        event(new Registered($companyUser)); // Laravel default event
        event(new CompanyRegistered($company)); // custom event

        $this->guard()->login($companyUser);

        UserVerification::generate($companyUser);
        UserVerification::send(
            $companyUser,
            'Company Verification',
            config('mail.recieve_to.address'),
            config('mail.recieve_to.name')
        );

        return $this->registered($request, $companyUser)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('company');
    }

}
