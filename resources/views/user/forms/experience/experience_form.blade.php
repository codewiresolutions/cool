<div class="modal-body">
    <div class="form-body">

        <div class="formrow" id="div_title">
            <input class="form-control" id="title" placeholder="{{__('Experience Title')}}" name="title" type="text"
                   value="{{ isset($resume_data['experience'][0]['jobTitle']) ? $resume_data['experience'][0]['jobTitle'] : (isset($profileExperience) ? $profileExperience->title : '') }}">
            <span class="help-block title-error text-danger"></span>
        </div>

        <div class="formrow" id="div_company">
            <input class="form-control" id="company" placeholder="{{__('Company')}}" name="company" type="text"
                   value="{{ isset($resume_data['experience'][0]['companyName']) ? $resume_data['experience'][0]['companyName'] : (isset($profileExperience)? $profileExperience->company : '') }}">
            <span class="help-block company-error text-danger"></span>
        </div>

        <div class="row">
            <div class="formrow col-md-4" id="div_country_id">
                <?php $country_id = (isset($profileExperience) ? $profileExperience->country_id : $siteSetting->default_country_id); ?>
                {!! Form::select('country_id', [''=>__('Select Country')]+$countries, $country_id, ['class'=>'form-control', 'id'=>'experience_country_id']) !!}
                <span class="help-block country_id-error text-danger"></span>
            </div>

            <div class="formrow col-md-4" id="div_state_id">
                <span id="default_state_experience_dd">
                    {!! Form::select('state_id', [''=>__('Select State')], null, ['class'=>'form-control', 'id'=>'experience_state_id']) !!}
                </span>
                <span class="help-block state_id-error text-danger"></span>
            </div>

            <div class="formrow col-md-4" id="div_city_id">
                <span id="default_city_experience_dd">
                    {!! Form::select('city_id', [''=>__('Select City')], null, ['class'=>'form-control', 'id'=>'city_id']) !!}
                </span>
                <span class="help-block city_id-error text-danger"></span>
            </div>
        </div>

        <div class="row">
            <div class="formrow col-md-6" id="div_date_start">
                <input class="form-control datepicker" autocomplete="off" id="date_start"
                       placeholder="{{__('Experience Start Date')}}" name="date_start" type="text"
                       value="{{ isset($resume_data['experience'][0]['startDate']) ? $resume_data['experience'][0]['startDate'] : (isset($profileExperience)? $profileExperience->date_start->format('Y-m-d') : '') }}">
                <span class="help-block date_start-error text-danger"></span>
            </div>

            <div class="formrow col-md-6" id="div_date_end">
                <input class="form-control datepicker" autocomplete="off" id="date_end"
                       placeholder="{{__('Experience End Date')}}" name="date_end" type="text"
                       value="{{ isset($resume_data['experience'][0]['endDate']) ? $resume_data['experience'][0]['endDate'] : (isset($profileExperience)? $profileExperience->date_end->format('Y-m-d'):'') }}">
                <span class="help-block date_end-error text-danger"></span>
            </div>
        </div>

        <div class="formrow" id="div_is_currently_working">
            <label for="is_currently_working" class="bold d-block mb-2">{{ __('Currently Working?') }}</label>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_currently_working" id="currently_working"
                               value="1" {{ isset($profileExperience) && $profileExperience->is_currently_working == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="currently_working">{{ __('Yes') }}</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_currently_working"
                               id="not_currently_working"
                               value="0" {{ isset($profileExperience) && $profileExperience->is_currently_working == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="not_currently_working">{{ __('No') }}</label>
                    </div>
                </div>
            </div>
            <span class="help-block is_currently_working-error text-danger"></span>
        </div>


        <div class="formrow" id="div_description">
            <textarea name="description" class="form-control" id="description"
                      placeholder="{{__('Experience description')}}">{{ isset($resume_data['experience'][0]['description']) ? $resume_data['experience'][0]['description'] : (isset($profileExperience)? $profileExperience->description:'') }}</textarea>
            <span class="help-block description-error text-danger"></span>
        </div>

    </div>
</div>
