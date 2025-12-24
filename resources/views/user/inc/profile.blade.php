{!! Form::model($user, array('method' => 'put', 'route' => array('my.profile'), 'class' => 'form', 'files'=>true)) !!}

<h5>{{__('Personal Information')}}</h5>

<div class="row">
    <div class="col-md-6">
        <div class="formrow">
            <label>{{__('Profile Photo')}}</label>
            {{ ImgUploader::print_image("user_images/$user->image", 100, 100) }} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow">
            <div id="thumbnail"></div>
            <label class="btn btn-default"> {{__('Select Profile Photo')}}
                <input type="file" name="image" id="image" style="display: none;" accept="image/*">
            </label>
            {!! APFrmErrHelp::showErrors($errors, 'image') !!} </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="formrow">
            <label>{{__('Banner Pic')}}</label>
            {{ ImgUploader::print_image("user_images/$user->cover_image", 120, 50) }} </div>
    </div>
    
    <div class="col-md-6">
        <div class="formrow">
            <div id="thumbnail_cover_image"></div>
            <label class="btn btn-default"> {{__('Select Banner Pic')}}
                <input type="file" name="cover_image" id="cover_image" style="display: none;" accept="image/*">
            </label>
            {!! APFrmErrHelp::showErrors($errors, 'cover_image') !!}
            <small class="form-text text-muted">
                Only image files are allowed (e.g., .jpg, .jpeg, .png, .gif).
            </small>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'first_name') !!}">
            <label for="">{{__('First Name')}}<span style="color:red"> *</span></label>
            {!! Form::text('first_name', null, array('class'=>'form-control', 'id'=>'first_name', 'placeholder'=>__('First Name'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'first_name') !!} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'middle_name') !!}">
            <label for="">{{__('Middle Name')}}</label>
            {!! Form::text('middle_name', null, array('class'=>'form-control', 'id'=>'middle_name', 'placeholder'=>__('Middle Name'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'middle_name') !!}</div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'last_name') !!}">
            <label for="">{{__('Last Name')}}</label>
            {!! Form::text('last_name', null, array('class'=>'form-control', 'id'=>'last_name', 'placeholder'=>__('Last Name'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'last_name') !!}</div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'date_of_birth') !!}">
            <?php
            if (!empty($user->date_of_birth)) {
                $d = $user->date_of_birth;
            } else {
                $d = date('Y-m-d', strtotime('-16 years'));
            }
            $dob = old('date_of_birth') ? date('Y-m-d', strtotime(old('date_of_birth'))) : date('Y-m-d', strtotime($d));
            ?>
            <label for="">{{__('Date of Birth')}}</label>
            {!! Form::date('date_of_birth', $dob, array('class'=>'form-control', 'id'=>'date_of_birth', 'placeholder'=>__('Date of Birth'), 'autocomplete'=>'off')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'date_of_birth') !!} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'nationality_id') !!}">
            <label for="">{{__('Nationality')}}<span style="color:red"> *</span></label>
            {!! Form::select('nationality_id', [''=>__('Select Nationality')]+$nationalities, null, array('class'=>'form-control', 'id'=>'nationality_id')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'nationality_id') !!} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'national_id_card_number') !!}">
            <label for="">{{__('Passport Number')}}</label>
            {!! Form::text('national_id_card_number', null, array('class'=>'form-control', 'id'=>'national_id_card_number', 'placeholder'=>__('Passport Number#'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'national_id_card_number') !!} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'passport_expiry') !!}">
            <label for="">{{__('Passport Expiry Date')}}</label>
            {!! Form::date('passport_expiry', old('passport_expiry'), array('class'=>'form-control', 'id'=>'passport_expiry', 'placeholder'=>__('Passport Expiry Date'), 'autocomplete'=>'off')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'passport_expiry') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'marital_status_id') !!}">
            <label for="">{{__('Marital Status')}}</label>
            {!! Form::select('marital_status_id', [''=>__('Select Marital Status')]+$maritalStatuses, null, array('class'=>'form-control', 'id'=>'marital_status_id')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'marital_status_id') !!} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'gender_id') !!}">
            <label for="">{{__('Gender')}}<span style="color:red"> *</span></label>
            {!! Form::select('gender_id', [''=>__('Select Gender')]+$genders, null, array('class'=>'form-control', 'id'=>'gender_id')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'gender_id') !!} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'country_id') !!}">
            <label for="">{{__('Country of Residence')}}<span style="color:red"> *</span></label>
            <?php $country_id = old('country_id', (isset($user) && (int)$user->country_id > 0) ? $user->country_id : $siteSetting->default_country_id); ?>
            {!! Form::select('country_id', [''=>__('Select Country')]+$countries, $country_id, array('class'=>'form-control', 'id'=>'country_id')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'country_id') !!} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'state_id') !!}">
            <label for="">{{__('State of Residence')}}<span style="color:red"> *</span></label>
            <span id="state_dd"> {!! Form::select('state_id', [''=>__('Select State')], null, array('class'=>'form-control', 'id'=>'state_id')) !!} </span> {!! APFrmErrHelp::showErrors($errors, 'state_id') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'city_id') !!}">
            <label for="">{{__('City of Residence')}}<span style="color:red"> *</span></label>
            <span id="city_dd"> {!! Form::select('city_id', [''=>__('Select City')], null, array('class'=>'form-control', 'id'=>'city_id')) !!} </span> {!! APFrmErrHelp::showErrors($errors, 'city_id') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow">
            <label for="mobile_num">{{ __('Mobile Number') }}<span style="color:red"> *</span></label>
            <div class="input-group">
                <span class="input-group-text" id="mobile_prefix">+XX</span>
                {!! Form::text('mobile_num', null, ['class' => 'form-control', 'id' => 'mobile_num', 'placeholder' => __('Mobile Number'), 'aria-describedby' => 'mobile_prefix']) !!}
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="formrow">
            <label for="phone">{{ __('Alternate Contact') }}</label>
            <div class="input-group">
                <span class="input-group-text" id="phone_prefix">+XX</span>
                {!! Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone', 'placeholder' => __('Phone'), 'aria-describedby' => 'phone_prefix']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'street_address') !!}">
            <label for="">{{__('Address')}}</label>
            {!! Form::textarea('street_address', null, array('class'=>'form-control', 'id'=>'street_address', 'placeholder'=>__('Street Address'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'street_address') !!} </div>
    </div>
</div>

<hr>
<div class="row">
    <div class="col-md-12">
        <div class="formrow">
            <h5 for="" style="">{{__('Your Education Details')}}</h5>
            <div id="education_div"></div>
            <div class="text-right mt-2">
                <a href="javascript:" class="btn btn-success" onclick="showProfileEducationModal();">
                    {{__('Add Education')}}
                </a>
            </div>
        </div>
    </div>
</div>

<hr>
<div class="row">
    <div class="col-md-12">
        <div class="formrow">
            <h5 for="" style="">{{__('Your Languuage Details')}}</h5>
            <div id="language_div"></div>
            <div class="text-right mt-2">
                <a href="javascript:" class="btn btn-success" onclick="showProfileLanguageModal();">
                    {{__('Add Language')}}
                </a>
            </div>
        </div>
    </div>
</div>
<hr>
<h5>{{__('Add Video Profile')}}</h5>

<div class="row">
    <div class="col-md-12" id="video_link_id">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'video_link') !!}">
            <label for="">{{__('Sample Video')}} - <a href="<?= url('https://www.youtube.com/watch?v=gyFaBZ_BQhc'); ?>">https://www.youtube.com/watch?v=gyFaBZ_BQhc</a>
            </label>
            {!! Form::textarea('video_link', null, array('class'=>'form-control', 'id'=>'video_link', 'placeholder'=>__('Video Link'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'video_link') !!} </div>
    </div>
</div>
<hr>

<h5>{{__('Career Information')}}</h5>

<div class="row">
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_experience_id') !!}">
            <label for="">{{__('Job Experience')}}</label>
            {!! Form::select('job_experience_id', [''=>__('Select Experience')]+$jobExperiences, null, array('class'=>'form-control', 'id'=>'job_experience_id')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'job_experience_id') !!} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'career_level_id') !!}">
            <label for="">{{__('Career Level')}}</label>
            {!! Form::select('career_level_id', [''=>__('Select Career Level')]+$careerLevels, null, array('class'=>'form-control', 'id'=>'career_level_id')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'career_level_id') !!} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'industry_id') !!}">
            <label for="">{{__('Select Industry')}}<span style="color:red"> *</span></label>
            {!! Form::select('industry_id', [''=>__('Select Industry')]+$industries, null, array('class'=>'form-control', 'id'=>'industry_id')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'industry_id') !!} </div>
    </div>
{{--    <div class="col-md-6">--}}
{{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'functional_area_id') !!}">--}}
{{--            <label for="">{{__('Functional Area')}}<span style="color:red"> *</span></label>--}}
{{--            {!! Form::select('functional_area_id', [''=>__('Select Functional Area')]+$functionalAreas, null, array('class'=>'form-control', 'id'=>'functional_area_id')) !!}--}}
{{--            {!! APFrmErrHelp::showErrors($errors, 'functional_area_id') !!} </div>--}}
{{--    </div>--}}


    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'functional_area_id') !!}">
            <label>
                {{ __('Functional Area') }}
                <span style="color:red"> *</span>
            </label>

            {!! Form::select(
                'functional_area_id',
                ['' => __('Select Functional Area')] + $functionalAreas + ['custom' => __('Custom')],
                null,
                ['class' => 'form-control', 'id' => 'functional_area_id']
            ) !!}

            {!! APFrmErrHelp::showErrors($errors, 'functional_area_id') !!}
        </div>
    </div>

    <!-- Custom input (hidden by default) -->
    <div class="col-md-6" id="custom_functional_area_div" style="display:none;">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'functional_area') !!}">
            <label>{{ __('Custom Functional Area') }}</label>
            {!! Form::text('functional_area', null, [
                'class' => 'form-control',
                'id' => 'functional_area_custom',
                'placeholder' => __('Enter custom functional area')
            ]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'functional_area') !!}
        </div>
    </div>


    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_currency') !!}">
            <label for="">{{__('Salary Currency')}}<span style="color:red"> *</span></label>
            <!-- @php
                $salary_currency = Request::get('salary_currency', (isset($user) && !empty($user->salary_currency))? $user->salary_currency:$siteSetting->default_currency_code);
            @endphp
            {!! Form::text('salary_currency', $salary_currency, array('class'=>'form-control', 'id'=>'salary_currency', 'placeholder'=>__('Salary Currency'), 'autocomplete'=>'off')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'salary_currency') !!} -->
            <select class="form-control" required id="salary_currency" name="salary_currency">
                <?php
                if (isset($currencies) && $currencies != '' && is_array($currencies) && count($currencies) > 0) { ?>
                <option value="">Select Salary Currency</option><?php
                                                                foreach ($currencies as $key => $currency) { ?>
                <option <?php if (isset($user) && !empty($user->salary_currency) && $user->salary_currency == $currency) {
                    echo "selected";
                } ?> value="<?php echo $currency;?>"><?php echo $currency; ?></option>
                    <?php
                }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'current_salary') !!}">
            <label for="">{{__('Current Salary')}}<span style="color:red"> *</span></label>
            {!! Form::text('current_salary', null, array('class'=>'form-control', 'id'=>'current_salary', 'placeholder'=>__('Current Salary'),'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');")) !!}
            {!! APFrmErrHelp::showErrors($errors, 'current_salary') !!} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'expected_salary') !!}">
            <label for="">{{__('Expected Salary')}}<span style="color:red"> *</span></label>
            {!! Form::text('expected_salary', null, array('class'=>'form-control', 'id'=>'expected_salary', 'placeholder'=>__('Expected Salary'),'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');")) !!}
            {!! APFrmErrHelp::showErrors($errors, 'expected_salary') !!} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'notice_period') !!}">
            <label for="notice_period">{{ __('Notice Period') }}<span style="color:red"> *</span></label>
            {!! Form::select('notice_period', ['30' => '30 days', '60' => '60 days', '90' => '90 days'], null, ['class'=>'form-control', 'required'=>'required', 'id'=>'notice_period', 'placeholder' => __('Select Notice Period')]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'notice_period') !!}
        </div>
    </div>


</div>


<div class="row">
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'is_subscribed') !!}">
            <?php
            $is_checked = 'checked="checked"';
            if (old('is_subscribed', ((isset($user)) ? $user->is_subscribed : 1)) == 0) {
                $is_checked = '';
            }
            ?>
            <input type="checkbox" value="1" name="is_subscribed" {{$is_checked}} />
            {{__('Subscribe to news letter')}}
            {!! APFrmErrHelp::showErrors($errors, 'is_subscribed') !!}
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="checkbox">
            <label>
                <input type="hidden" name="hide_salary" value="0">
                <input type="checkbox"
                       id="hide_salary"
                       name="hide_salary"
                       value="1"
                        {{ $user->hide_salary == 1 ? 'checked' : '' }}>
                {{ __('Hide Salary') }}
            </label>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="formrow">
            <button type="submit" class="btn">{{__('Save Personal Information')}} <i class="fa fa-arrow-circle-right"
                                                                                     aria-hidden="true"></i></button>
        </div>
    </div>
</div>


{!! Form::close() !!}
<hr>
@push('styles')
    <style type="text/css">
        .datepicker > div {
            display: block;
        }
    </style>
@endpush
@push('scripts')
<script>
    (function () {
        var functionalAreaSelect = document.getElementById('functional_area_id');
        var customDiv = document.getElementById('custom_functional_area_div');
        var customInput = document.getElementById('functional_area_custom');

        function toggleCustom() {
            if (!functionalAreaSelect || !customDiv) return;

            if (functionalAreaSelect.value === 'custom') {
                customDiv.style.display = 'block';
            } else {
                customDiv.style.display = 'none';
                if (customInput) customInput.value = '';
            }
        }

        if (functionalAreaSelect) {
            functionalAreaSelect.addEventListener('change', toggleCustom);
            toggleCustom();
        }
    })();
</script>



    <script type="text/javascript">
        $(document).ready(function () {
            initDatepicker();

            // Set default states/cities
            filterStates({{ old('state_id', $user->state_id ?? 0) }});
            filterCities({{ old('city_id', $user->city_id ?? 0) }});

            const countryDialCodes = {!! json_encode($dialCodes ?? []) !!};
            const phoneMaxLengths = {!! json_encode($phoneLengths ?? []) !!};

            const $countrySelect = $('#country_id');
            const $mobilePrefix = $('#mobile_prefix');
            const $phonePrefix = $('#phone_prefix');
            const $mobileInput = $('#mobile_num');
            const $phoneInput = $('#phone');

            function updateDialCodeAndLength() {
                const selectedId = parseInt($countrySelect.val());
                const dialCode = countryDialCodes[selectedId] || '+XX';
                const maxLength = phoneMaxLengths[selectedId] || 15;

                $mobilePrefix.text(dialCode);
                $phonePrefix.text(dialCode);

                $mobileInput.attr('maxlength', maxLength);
                $phoneInput.attr('maxlength', maxLength);
            }

            updateDialCodeAndLength();

            $countrySelect.on('change', function () {
                updateDialCodeAndLength();
                filterStates(0);
            });

            $(document).on('change', '#state_id', function (e) {
                e.preventDefault();
                filterCities(0);
            });

            // Thumbnail previews
            $('#image').on('change', function () {
                showThumbnail(this.files, '#thumbnail');
            });

            $('#cover_image').on('change', function () {
                showThumbnail(this.files, '#thumbnail_cover_image');
            });

            function showThumbnail(files, container) {
                const $container = $(container).html('');

                Array.from(files).forEach(file => {
                    if (!file.type.match(/image.*/)) {
                        console.log("Not an image.");
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $container.append(`
                        <div class="fileattached">
                            <img height="100px" src="${e.target.result}" alt="thumbnail">
                            <div>${file.name}</div>
                            <div class="clearfix"></div>
                        </div>
                    `);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });

        function filterStates(state_id) {
            const country_id = $('#country_id').val();
            if (country_id) {
                $.post("{{ route('filter.lang.states.dropdown') }}", {
                    country_id: country_id,
                    state_id: state_id,
                    _token: '{{ csrf_token() }}'
                }, function (response) {
                    $('#state_dd').html(response);
                    filterCities({{ old('city_id', $user->city_id ?? 0) }});
                });
            }
        }

        function filterCities(city_id) {
            const state_id = $('#state_id').val();
            if (state_id) {
                $.post("{{ route('filter.lang.cities.dropdown') }}", {
                    state_id: state_id,
                    city_id: city_id,
                    _token: '{{ csrf_token() }}'
                }, function (response) {
                    $('#city_dd').html(response);
                });
            }
        }

        function initDatepicker() {
            $(".datepicker").datepicker({
                autoclose: true,
                format: 'yyyy-m-d'
            });
        }
    </script>
@endpush
