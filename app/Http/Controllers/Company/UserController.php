<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyUserRequest;
use App\Mail\InviteUserMail;
use App\Models\CompanyUser;
use Auth;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:company', 'company.admin'])->except(['acceptInvite', 'completeInvite']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     * @throws Exception
     */
    public function index()
    {
        $company = Auth::guard('company')->user()?->company;

        if (!$company) {
            throw new Exception('No authenticated company found.');
        }

        $companyUsers = CompanyUser::where('company_id', $company->id)->paginate(10);
        return view('company.users.index', compact('companyUsers', 'company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function store(CompanyUserRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $company = Auth::guard('company')->user()?->company;

            if (!$company) {
                throw new Exception('No authenticated company found.');
            }

            // Restrict if quota exceeded
            if ($company->availed_users_quota >= $company->users_quota) {
                return redirect()
                    ->route('company.users.index')
                    ->with('error', __('User quota exceeded. Please upgrade your plan to add more users.'));
            }

            $token = Str::random(40);
            $expiresAt = now()->addHours(2);

            $user = CompanyUser::create([
                'company_id' => $company->id,
                'email' => $validated['email'],
                'name' => $validated['name'],
                'role' => 'staff',
                'invited_at' => now(),
                'invite_token' => $token,
                'invite_token_expires_at' => $expiresAt,
            ]);

            $url = URL::temporarySignedRoute(
                'company-users.accept-invite',
                $expiresAt,
                ['token' => $token, 'id' => $user->id]
            );

            $company->increment('availed_users_quota', 1, [
                'updated_at' => now(),
            ]);

            Mail::to($user->email)->send(new InviteUserMail($url));

            DB::commit();

            flash("Invitation link sent to {$user->email}.")->success();
            return Redirect::route('company.users.index');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Error sending company user invite', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            flash('Something went wrong while sending the invite.')->error();
            return redirect()->back();
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|RedirectResponse|View
     */
    public function create()
    {
        $company = Auth::guard('company')->user()?->company;

        if (!$company) {
            abort(403, 'Unauthorized action.');
        }

        if ($company->availed_users_quota >= $company->users_quota) {
            return redirect()
                ->route('company.users.index')
                ->with('error', __('You have reached your user limit. Please upgrade your plan to add more users.'));
        }

        return view('company.users.create');
    }

    public function acceptInvite(Request $request, $id)
    {
        $invite = CompanyUser::where('id', $id)
            ->where('invite_token', $request->token)
            ->where('invite_token_expires_at', '>', now())
            ->firstOrFail();

        return view('company.users.accept-invite', ['invite' => $invite]);
    }

    public function completeInvite(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $invite = CompanyUser::where('id', $id)
            ->where('invite_token', $request->token)
            ->where('invite_token_expires_at', '>', now())
            ->firstOrFail();

        $invite->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'is_active' => true,
            'invite_token' => null,
            'invite_token_expires_at' => null,
            'accepted_at' => now(),
            'email_verified_at' => now(),
        ]);

        Auth::guard('company')->login($invite);
        $request->session()->forget('url.intended');

        return redirect()->route('company.home')->with('success', 'Your account has been activated!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param CompanyUser $companyUser
     * @return RedirectResponse
     */
    public function update(CompanyUserRequest $request, CompanyUser $companyUser)
    {
        if ($companyUser->company_id !== Auth::guard('company')->user()?->company->id) {
            flash('You are not authorized to update this user.')->error();
            return redirect()->back();
        }

        $data = $request->validated();

        $companyUser->update($data);

        flash('User updated successfully.')->success();

        return redirect()->route('company.users.index');
    }


    /**
     * Display the specified resource.
     *
     * @param CompanyUser $companyUser
     * @return Response
     */
    public function show(CompanyUser $companyUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CompanyUser $companyUser
     * @return View
     */
    public function edit(CompanyUser $companyUser)
    {
        return view('company.users.edit', compact('companyUser'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CompanyUser $companyUser
     * @return RedirectResponse
     */
    public function destroy(CompanyUser $companyUser)
    {
        $company = $companyUser->company;
        if ($company->id !== Auth::guard('company')->user()?->company->id) {
            flash('You are not authorized to delete this user.')->error();
            return redirect()->back();
        }

        try {
            $companyUser->delete();

            $company->decrement('availed_users_quota', 1, [
                'updated_at' => now(),
            ]);

            flash('User successfully deleted.')->success();
        } catch (Exception $e) {
            flash('Failed to delete user: ' . $e->getMessage())->error();
        }

        return redirect()->back();
    }
}
