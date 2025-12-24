<div class="col-md-3 col-sm-6"> 
	
	
	
    <!-- Side Bar start -->
    <div class="sidebar">
        <input type="hidden" name="search" value="{{Request::get('search', '')}}"/>


<!-- Jobs By Functional Area -->
<div class="widget">
    <h4 class="widget-title">{{__('By Functional Areas')}}</h4>
    <ul class="optionlist view_more_ul functional-areas-list">
        @if(isset($functionalAreaIdsArray) && count($functionalAreaIdsArray))
            @php
                $functionalAreas = App\FunctionalArea::whereIn('functional_area_id', $functionalAreaIdsArray)
                    ->lang()
                    ->active()
                    ->orderBy('functional_area') // Order by the 'functional_area' column
                    ->get();
            @endphp
            @foreach($functionalAreas as $functionalArea)
                @php
                    $checked = (in_array($functionalArea->functional_area_id, Request::get('functional_area_id', array()))) ? 'checked="checked"' : '';
                @endphp
                <li>
                    <input type="checkbox" name="functional_area_id[]" id="functional_area_id_{{ $functionalArea->functional_area_id }}" value="{{ $functionalArea->functional_area_id }}" {{ $checked }} onclick="submit_form()">
                    <label for="functional_area_id_{{ $functionalArea->functional_area_id }}"></label>
                    {{ $functionalArea->functional_area }} <span>{{ App\User::countNumJobSeekers('functional_area_id', $functionalArea->functional_area_id) }}</span>
                </li>
            @endforeach
        @endif
    </ul>
    <span class="text text-primary view_more" data-target=".functional-areas-list">{{__('View More')}}</span>
    <span class="text text-primary view_less" data-target=".functional-areas-list" style="display: none;">{{ __('View Less') }}</span>
</div>
<!-- Jobs By Functional Area end -->

<!-- Jobs By Skill -->

<!-- Jobs By Skills end -->

<!-- Jobs By Career Level -->
<div class="widget">
    <h4 class="widget-title">{{__('By Career Level')}}</h4>
    <ul class="optionlist view_more_ul career-level-list">
        @if(isset($careerLevelIdsArray) && count($careerLevelIdsArray))
            @php
                $careerLevels = App\CareerLevel::whereIn('career_level_id', $careerLevelIdsArray)
                    ->lang()
                    ->active()
                    ->orderBy('career_level') // Order by the 'career_level' column
                    ->get();
            @endphp
            @foreach($careerLevels as $careerLevel)
                @php
                    $checked = (in_array($careerLevel->career_level_id, Request::get('career_level_id', array()))) ? 'checked="checked"' : '';
                @endphp
                <li>
                    <input type="checkbox" name="career_level_id[]" id="career_level_{{ $careerLevel->career_level_id }}" value="{{ $careerLevel->career_level_id }}" {{ $checked }} onclick="submit_form()">
                    <label for="career_level_{{ $careerLevel->career_level_id }}"></label>
                    {{ $careerLevel->career_level }} <span>{{ App\User::countNumJobSeekers('career_level_id', $careerLevel->career_level_id) }}</span>
                </li>
            @endforeach
        @endif
    </ul>
    <span class="text text-primary view_more" data-target=".career-level-list">{{__('View More')}}</span>
    <span class="text text-primary view_less" data-target=".career-level-list" style="display: none;">{{ __('View Less') }}</span>
</div>
<!-- Jobs By Career Level end -->

<!-- Jobs By Experience -->
<div class="widget">
    <h4 class="widget-title">{{__('By Experience')}}</h4>
    <ul class="optionlist view_more_ul experience-list">
        @if(isset($jobExperienceIdsArray) && count($jobExperienceIdsArray))
            @foreach($jobExperienceIdsArray as $key=>$job_experience_id)
                @php
                    $jobExperience = App\JobExperience::where('job_experience_id', '=', $job_experience_id)->lang()->active()->first();
                @endphp
                @if(null !== $jobExperience)
                    @php
                        $checked = (in_array($jobExperience->job_experience_id, Request::get('job_experience_id', array()))) ? 'checked="checked"' : '';
                    @endphp
                    <li>
                        <input type="checkbox" name="job_experience_id[]" id="job_experience_{{$jobExperience->job_experience_id}}" value="{{$jobExperience->job_experience_id}}" {{$checked}} onclick="submit_form()">
                        <label for="job_experience_{{$jobExperience->job_experience_id}}"></label>
                        {{$jobExperience->job_experience}} <span>{{App\User::countNumJobSeekers('job_experience_id', $jobExperience->job_experience_id)}}</span>
                    </li>
                @endif
            @endforeach
        @endif
    </ul>
    <span class="text text-primary view_more" data-target=".experience-list">{{__('View More')}}</span>
    <span class="text text-primary view_less" data-target=".experience-list" style="display: none;">{{ __('View Less') }}</span>
</div>
<!-- Jobs By Experience end -->


<!-- Jobs By City -->
<div class="widget">
    <h4 class="widget-title">{{__('By City')}}</h4>
    <ul class="optionlist view_more_ul city-list">
        @if(isset($cityIdsArray) && count($cityIdsArray))
            @php
                $cities = App\City::whereIn('city_id', $cityIdsArray)
                    ->lang()
                    ->active()
                    ->orderBy('city') // Order by the 'city' column
                    ->get();
            @endphp
            @foreach($cities as $city)
                @php
                    $checked = (in_array($city->city_id, Request::get('city_id', array()))) ? 'checked="checked"' : '';
                @endphp
                <li>
                    <input type="checkbox" name="city_id[]" id="city_{{ $city->city_id }}" value="{{ $city->city_id }}" {{ $checked }} onclick="submit_form()">
                    <label for="city_{{ $city->city_id }}"></label>
                    {{ $city->city }} <span>{{ App\User::countNumJobSeekers('city_id', $city->city_id) }}</span>
                </li>
            @endforeach
        @endif
    </ul>
    <span class="text text-primary view_more" data-target=".city-list">{{__('View More')}}</span>
    <span class="text text-primary view_less" data-target=".city-list" style="display: none;">{{ __('View Less') }}</span>
</div>
<!-- Jobs By City end -->

<!-- Jobs By Gender -->
<div class="widget">
    <h4 class="widget-title">{{__('By Gender')}}</h4>
    <ul class="optionlist view_more_ul gender-list">
        @if(isset($genderIdsArray) && count($genderIdsArray))
            @foreach($genderIdsArray as $key=>$gender_id)
                @php
                    $gender = App\Gender::where('gender_id', '=', $gender_id)->lang()->active()->first();
                @endphp
                @if(null !== $gender)
                    @php
                        $checked = (in_array($gender->gender_id, Request::get('gender_id', array()))) ? 'checked="checked"' : '';
                    @endphp
                    <li>
                        <input type="checkbox" name="gender_id[]" id="gender_{{$gender->gender_id}}" value="{{$gender->gender_id}}" {{$checked}} onclick="submit_form()">
                        <label for="gender_{{$gender->gender_id}}"></label>
                        {{$gender->gender}} <span>{{App\User::countNumJobSeekers('gender_id', $gender->gender_id)}}</span>
                    </li>
                @endif
            @endforeach
        @endif
    </ul>
    <span class="text text-primary view_more" data-target=".gender-list">{{__('View More')}}</span>
    <span class="text text-primary view_less" data-target=".gender-list" style="display: none;">{{ __('View Less') }}</span>
</div>
<!-- Jobs By Gender end -->



        



        <!-- Salary -->
        <div class="widget">
            <h4 class="widget-title">{{__('Salary Range')}}</h4>
            <div class="form-group">
                {!! Form::number('current_salary', Request::get('current_salary', null), array('class'=>'form-control', 'id'=>'current_salary', 'placeholder'=>__('Current Salary'))) !!}
            </div>
            <div class="form-group">
                {!! Form::number('expected_salary', Request::get('expected_salary', null), array('class'=>'form-control', 'id'=>'expected_salary', 'placeholder'=>__('Expected Salary'))) !!}
                <span style="color: red" id="salary_to_greater"></span>
            </div>
            <div class="form-group">
                {!! Form::select('salary_currency', ['' =>__('Select Salary Currency')]+$currencies, Request::get('salary_currency'), array('class'=>'form-control', 'id'=>'salary_currency')) !!}
                <!-- , $siteSetting->default_currency_code THE REASON WHY IT WAS NOT FILTERING RIGHT-->
            </div>
            <!-- Salary end --> 

            <!-- button -->
            <div class="searchnt">
            <button type="button" class="btn click_on_button_when_click_filter" onclick="searchJob()">
                    <i class="fa fa-search" aria-hidden="true"></i> {{__('Search')}}
                </button>
            </div>
            <!-- button end--> 
        </div>
        <!-- Side Bar end --> 
    </div>
</div>