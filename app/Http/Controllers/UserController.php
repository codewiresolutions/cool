<?php

namespace App\Http\Controllers;

use App\Alert;
use App\ApplicantMessage;
use App\Company;
use App\FavouriteCompany;
use App\Helpers\DataArrayHelper;
use App\Http\Requests\Front\UserFrontFormRequest;
use App\Subscription;
use App\Traits\CommonUserFunctions;
use App\Traits\ProfileCvsTrait;
use App\Traits\ProfileEducationTrait;
use App\Traits\ProfileExperienceTrait;
use App\Traits\ProfileLanguageTrait;
use App\Traits\ProfileProjectsTrait;
use App\Traits\ProfileSkillTrait;
use App\Traits\ProfileSummaryTrait;
use App\Traits\Skills;
use App\User;
use App\FunctionalArea;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use ImgUploader;
use Newsletter;
use Redirect;

class UserController extends Controller
{

    use CommonUserFunctions;
    use ProfileSummaryTrait;
    use ProfileCvsTrait;
    use ProfileProjectsTrait;
    use ProfileExperienceTrait;
    use ProfileEducationTrait;
    use ProfileSkillTrait;
    use ProfileLanguageTrait;
    use Skills;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth', ['only' => ['myProfile', 'updateMyProfile', 'viewPublicProfile']]);
        $this->middleware('auth', ['except' => ['showApplicantProfileEducation', 'showApplicantProfileProjects', 'showApplicantProfileExperience', 'showApplicantProfileSkills', 'showApplicantProfileLanguages']]);
    }

    public function account()
    {
        $user = Auth::user();
        return view('user.account', compact('user'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        flash(__('Your password has been successfully updated.'))->success();
        return redirect()->route('my.account');
    }


    public function viewPublicProfile($id)
    {

        $user = User::findOrFail($id);
        $profileCv = $user->getDefaultCv();

        return view('user.applicant_profile')
            ->with('user', $user)
            ->with('profileCv', $profileCv)
            ->with('page_title', $user->getName())
            ->with('form_title', 'Contact ' . $user->getName());
    }

    public function myProfile()
    {
        $user = User::findOrFail(Auth::user()->id);

        $data = [
            'genders' => DataArrayHelper::langGendersArray(),
            'maritalStatuses' => DataArrayHelper::langMaritalStatusesArray(),
            'nationalities' => DataArrayHelper::langNationalitiesArray(),
            'countries' => DataArrayHelper::langCountriesArray(),
            'jobExperiences' => DataArrayHelper::langJobExperiencesArray(),
            'careerLevels' => DataArrayHelper::langCareerLevelsArray(),
            'industries' => DataArrayHelper::langIndustriesArray(),
            'functionalAreas' => DataArrayHelper::langFunctionalAreasArray(),
            'currencies' => DataArrayHelper::currenciesArray(),
            'dialCodes' => config('phone.dial_codes'),
            'phoneLengths' => config('phone.phone_lengths'),
            'upload_max_filesize' => UploadedFile::getMaxFilesize() / (1024 * 1024),
            'user' => $user,
        ];

        return view('user.edit_profile', $data);
    }

    public function updateMyProfile(UserFrontFormRequest $request)
    {
    
        $user = User::findOrFail(Auth::user()->id);

        DB::beginTransaction();
        try {
            /*         * **************************************** */
            if ($request->hasFile('image')) {
                $is_deleted = $this->deleteUserImage($user->id);
                $image = $request->file('image');
                $fileName = ImgUploader::UploadImage('user_images', $image, $request->input('name'), 300, 300, false);
                $user->image = $fileName;
            }

            if ($request->hasFile('cover_image')) {
                $is_deleted = $this->deleteUserCoverImage($user->id);
                $cover_image = $request->file('cover_image');
                $fileName_cover_image = ImgUploader::UploadImage('user_images', $cover_image, $request->input('name'), 1140, 250, false);
                $user->cover_image = $fileName_cover_image;
            }

            $user->first_name = $request->input('first_name');
            $user->middle_name = $request->input('middle_name');
            $user->last_name = $request->input('last_name');
            $user->name = $user->getName();
            $user->father_name = $request->input('father_name');
            $user->date_of_birth = $request->input('date_of_birth');
            $user->gender_id = $request->input('gender_id');
            $user->marital_status_id = $request->input('marital_status_id');
            $user->nationality_id = $request->input('nationality_id');
            $user->national_id_card_number = $request->input('national_id_card_number');
            $user->country_id = $request->input('country_id');
            $user->state_id = $request->input('state_id');
            $user->city_id = $request->input('city_id');
            $user->phone = $request->input('phone');
            $user->mobile_num = $request->input('mobile_num');
            $user->job_experience_id = $request->input('job_experience_id');
            $user->career_level_id = $request->input('career_level_id');
            $user->industry_id = $request->input('industry_id');

            $functionalAreaId = $request->input('functional_area_id');
            if ($functionalAreaId === 'custom') {
                $customFunctionalArea = trim((string) $request->input('functional_area'));

                $nextSortOrder = (int) FunctionalArea::max('sort_order') + 1;

                $functionalArea = FunctionalArea::create([
                    'functional_area' => $customFunctionalArea,
                    'sort_order' => $nextSortOrder,
                    'is_active' => 1,
                    'is_default' => 1,
                    'lang' => 'en',
                ]);

                // In this project, many lookups reference `functional_area_id` (group id), not `id`.
                // So set functional_area_id to the newly created row's id if it's empty.
                if (empty($functionalArea->functional_area_id)) {
                    $functionalArea->functional_area_id = $functionalArea->id;
                    $functionalArea->save();
                }

                // Save the group id into users table (matches existing app flow)
                $user->functional_area_id = $functionalArea->functional_area_id;
            } else {
                $user->functional_area_id = $functionalAreaId;
            }

            $user->current_salary = $request->input('current_salary');
            $user->expected_salary = $request->input('expected_salary');
            $user->salary_currency = $request->input('salary_currency');
            $user->notice_period = $request->input('notice_period'); // Add this line
           
            $user->video_link = $request->video_link;
            $user->street_address = $request->input('street_address');
            $user->is_subscribed = $request->input('is_subscribed', 0);
            $user->hide_salary = $request->input('hide_salary', 0);

            $user->update();

            $this->updateUserFullTextSearch($user);

            Subscription::where('email', 'like', $user->email)->delete();
            if ((bool)$user->is_subscribed) {
                $subscription = Subscription::create([
                    'email' => $user->email,
                    'name' => $user->name,
                ]);

                Newsletter::subscribeOrUpdate($subscription->email, ['FNAME' => $subscription->name]);
            } else {
                Newsletter::unsubscribe($user->email);
            }

            DB::commit();

            flash(__('You have updated your profile successfully'))->success();
            return Redirect::route('my.profile');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function addToFavouriteCompany(Request $request, $company_slug)
    {
        $data['company_slug'] = $company_slug;
        $data['user_id'] = Auth::user()->id;
        $data_save = FavouriteCompany::create($data);
        flash(__('Company has been added in favorites list'))->success();
        return Redirect::route('company.detail', $company_slug);
    }

    public function removeFromFavouriteCompany(Request $request, $company_slug)
    {
        $user_id = Auth::user()->id;
        FavouriteCompany::where('company_slug', 'like', $company_slug)->where('user_id', $user_id)->delete();

        flash(__('Company has been removed from favorites list'))->success();
        return Redirect::route('company.detail', $company_slug);
    }

    public function myFollowings()
    {
        $user = User::findOrFail(Auth::user()->id);
        $companiesSlugArray = $user->getFollowingCompaniesSlugArray();
        $companies = Company::whereIn('slug', $companiesSlugArray)->get();

        return view('user.following_companies')
            ->with('user', $user)
            ->with('companies', $companies);
    }

    public function myMessages()
    {
        $user = User::findOrFail(Auth::user()->id);
        $messages = ApplicantMessage::where('user_id', '=', $user->id)
            ->orderBy('is_read', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.applicant_messages')
            ->with('user', $user)
            ->with('messages', $messages);
    }

    public function applicantMessageDetail($message_id)
    {
        $user = User::findOrFail(Auth::user()->id);
        $message = ApplicantMessage::findOrFail($message_id);
        $message->update(['is_read' => 1]);

        return view('user.applicant_message_detail')
            ->with('user', $user)
            ->with('message', $message);
    }

    public function myAlerts()
    {
        $alerts = Alert::where('email', Auth::user()->email)
            ->orderBy('created_at', 'desc')
            ->get();
        //dd($alerts);
        return view('user.applicant_alerts')
            ->with('alerts', $alerts);
    }

    public function delete_alert($id)
    {
        $alert = Alert::findOrFail($id);
        $alert->delete();
        $arr = array('msg' => 'A Alert has been successfully deleted. ', 'status' => true);
        return Response()->json($arr);
    }

}
