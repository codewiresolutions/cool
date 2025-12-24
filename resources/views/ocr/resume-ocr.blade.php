@extends('layouts.app')
@section('content')
    @include('includes.header')
    @include('includes.inner_page_title', ['page_title'=>__('Resume Upload')])
    
    <div class="listpgWraper">
        <div class="container">
            <div class="row">
                @include('includes.user_dashboard_menu')
                
                <div class="col-md-9 col-sm-8">
                    @empty($parsedData)
                        <h5>Resume Upload</h5>
                        <div class="userccount">
                            <div class="formpanel mt0">
                                <form method="POST" action="{{ route('resume-ocr-post') }}" accept-charset="UTF-8"
                                      class="form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            @if(Session::has('successMsg'))
                                                <div class="alert alert-success">
                                                    {{ Session::get('successMsg') }}
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="formrow">
                                                <label>Upload your resume (PDF)</label>
                                                <label for="file" class="btn btn-default">
                                                    <input type="file" name="file" id="file" required>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="formrow">
                                                <button type="submit" class="btn">
                                                    Submit <i class="fa fa-arrow-circle-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endempty
                    @isset($parsedData)
                        <h5>Resume Information</h5>
                        <div class="userccount">
                            <div class="formpanel mt0">
                                <div class="col-lg-12 col-sm-8">
                                    <div class="">
                                        {{-- Personal Info--}}
                                        <div class="card mb-4 shadow-sm rounded-4 personal-info-card">
                                            <div class="card-header bg-light fw-bold rounded-top-4 d-flex align-items-center justify-content-between">
                                                <h4 class="mb-0">
                                                    Personal Information
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <form id="updateUploadedResume" method="POST"
                                                      action="{{ url('resume-ocr') }}">
                                                    @csrf
                                                    <div class="row g-3">
                                                        <div class="col-md-6 mb-3 formrow">
                                                            <label for="first_name" class="form-label">First Name <span
                                                                        style='color:red;'>*</span></label>
                                                            <input class="form-control" id="first_name"
                                                                   name="first_name"
                                                                   type="text"
                                                                   value="{{  $parsedData['name']['first_name'] ?? '' }}"
                                                                   required>
                                                            <div class="invalid-feedback">This field is required.</div>
                                                        </div>
                                                        <div class="col-md-6 mb-3 formrow">
                                                            <label for="last_name" class="form-label">Last Name <span
                                                                        style='color:red;'>*</span></label>
                                                            <input class="form-control" id="last_name" name="last_name"
                                                                   type="text"
                                                                   value="{{ $parsedData['name']['last_name'] ?? '' }}"
                                                                   required>
                                                            <div class="invalid-feedback">This field is required.</div>
                                                        </div>
                                                        <div class="col-md-6 mb-3 formrow">
                                                            <label for="mobile_num" class="form-label">Mobile <span
                                                                        style='color:red;'>*</span></label>
                                                            <input class="form-control" id="mobile_num"
                                                                   name="mobile_num"
                                                                   type="text"
                                                                   value="{{ data_get($parsedData, 'phone.0.phone', '') }}"
                                                                   required>
                                                            <div class="invalid-feedback">This field is required.</div>
                                                        </div>
                                                        <div class="col-md-6 mb-3 formrow">
                                                            <label for="email" class="form-label">Email <span
                                                                        style='color:red;'>*</span></label>
                                                            <input class="form-control" id="email" name="email"
                                                                   type="email"
                                                                   value="{{ data_get($parsedData, 'email.0.email', '') }}"
                                                                   required>
                                                            <div class="invalid-feedback">This field is required.</div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        {{-- Education Section--}}
                                        @if (!empty($parsedData['education']) && is_array($parsedData['education']))
                                            @foreach($parsedData['education'] as $index => $education)
                                                <div class="card mb-4 shadow-sm rounded-4 education-card"
                                                     data-index="{{ $index }}">
                                                    <div class="card-header bg-light fw-bold rounded-top-4 d-flex align-items-center justify-content-between">
                                                        <h4 class="mb-0">
                                                            Education
                                                            @if(count($parsedData['education']) > 1)
                                                                {{ $index + 1 }}
                                                            @endif
                                                        </h4>
                                                        @if(count($parsedData['education']) > 1 && $index > 0)
                                                            <!-- Delete icon -->
                                                            <button type="button"
                                                                    class="delete-education border-0 bg-transparent p-0 text-danger"
                                                                    data-index="{{ $index }}" title="Remove Education">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="card-body">
                                                        <form id="educationForm">
                                                            <div class="row g-3">
                                                                
                                                                <div class="col-md-6 mb-3 formrow">
                                                                    <label class="form-label">Select Degree
                                                                        Level <span style='color:red;'>*</span></label>
                                                                    <select class="form-control"
                                                                            data-index="{{ $index }}"
                                                                            name="degree_level_id[{{ $index }}]"
                                                                            required>
                                                                        <option value="">Select Degree Level</option>
                                                                        @foreach($degreeLevels as $key => $level)
                                                                            <option value="{{ $key }}">
                                                                                {{ $level }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6 mb-3 formrow">
                                                                    <label class="form-label">Major Subjects <span
                                                                                style='color:red;'>*</span></label>
                                                                    <select class="form-control"
                                                                            data-index="{{ $index }}"
                                                                            name="major-subjects_id[{{ $index }}]"
                                                                            required>
                                                                        <option value="">Select Subject</option>
                                                                        @foreach($majorSubjects as $key => $subject)
                                                                            <option value="{{ $key }}" @selected(strtolower($education['course'] ?? '') == strtolower($subject))>
                                                                                {{ $subject }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-4 mb-3 formrow">
                                                                    <label class="form-label">Select Country <span
                                                                                style='color:red;'>*</span></label>
                                                                    <select class="form-control education-country"
                                                                            data-index="{{ $index }}"
                                                                            name="education_country_id[{{ $index }}]"
                                                                            required>
                                                                        <option value="">Select Country</option>
                                                                        @foreach($countries as $key => $country)
                                                                            <option value="{{$key}}">{{ $country }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-4 mb-3 formrow">
                                                                    <label class="form-label">Select
                                                                        State <span style='color:red;'>*</span></label>
                                                                    <select name="education_state_id[{{ $index }}]"
                                                                            id="education_state_id_{{ $index }}"
                                                                            class="form-control education-state"
                                                                            data-index="{{ $index }}" required>
                                                                        <option value="">Select State</option>
                                                                    </select>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-4 mb-3 formrow">
                                                                    <label class="form-label">Select City <span
                                                                                style='color:red;'>*</span></label>
                                                                    <select class="form-control education-city"
                                                                            id="education_city_id_{{ $index }}"
                                                                            data-index="{{ $index }}"
                                                                            name="education_city_id[{{ $index }}]"
                                                                            required>
                                                                        <option>Select City</option>
                                                                    </select>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6 mb-3 formrow">
                                                                    <label class="form-label">Institution <span
                                                                                style='color:red;'>*</span></label>
                                                                    <input type="text" name="institution"
                                                                           class="form-control"
                                                                           value="{{ $education['institute'] ?? '' }}"
                                                                           required>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6 mb-3 formrow">
                                                                    <label class="form-label">Completion Year <span
                                                                                style='color:red;'>*</span></label>
                                                                    <select class="form-control" name="completion_year">
                                                                        @for($year = date('Y'); $year >= 1950; $year--)
                                                                            <option value="{{ $year }}"
                                                                                    @if(($education['to_year'] ?? '') === $year) selected @endif>{{ $year }}</option>
                                                                        @endfor
                                                                    </select>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6 mb-3 formrow">
                                                                    <label class="form-label">Result Type <span
                                                                                style='color:red;'>*</span></label>
                                                                    <select class="form-control result_type"
                                                                            data-index="{{ $index }}"
                                                                            name="education_result_type[{{ $index }}]"
                                                                            required>
                                                                        <option value="">Select Result Type</option>
                                                                        @foreach($resultTypes as $key => $type)
                                                                            <option value="{{$key}}">{{ $type }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6 mb-3 formrow">
                                                                    <label class="form-label">Degree Result <span
                                                                                style='color:red;'>*</span></label>
                                                                    <input type="text" name="result"
                                                                           class="form-control"
                                                                           placeholder="3.8 / 4.0" required>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                            
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        
                                        {{-- Experience Section--}}
                                        @if (!empty($parsedData['employer']) && is_array($parsedData['employer']))
                                            @foreach($parsedData['employer'] as $index => $employer)
                                                <div class="card mb-4 shadow-sm rounded-4 experience-card">
                                                    <div class="card-header bg-light fw-bold rounded-top-4 d-flex align-items-center justify-content-between">
                                                        <h4 class="mb-0">
                                                            Experience
                                                            @if(count($parsedData['employer']) > 1)
                                                                {{ $index + 1 }}
                                                            @endif
                                                        </h4>
                                                        @if(count($parsedData['employer']) > 1 && $index > 0)
                                                            <!-- Delete icon -->
                                                            <button type="button"
                                                                    class="delete-experience border-0 bg-transparent p-0 text-danger"
                                                                    data-index="{{ $index }}" title="Remove Experience">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="card-body">
                                                        <form id="experienceForm">
                                                            <div class="row g-3">
                                                                <div class="col-md-6 mb-3 formrow">
                                                                    <label class="form-label">Experience Title
                                                                        <span style='color:red;'>*</span>
                                                                    </label>
                                                                    <input type="text" name="title[{{ $index }}]"
                                                                           class="form-control"
                                                                           placeholder="Title"
                                                                           value="{{ $employer['company_name'] ?? '' }}"
                                                                           required>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6 mb-3 formrow">
                                                                    <label class="form-label">Company
                                                                        <span style='color:red;'>*</span>
                                                                    </label>
                                                                    <input type="text" name="company[{{ $index }}]"
                                                                           class="form-control"
                                                                           placeholder="Company Name"
                                                                           value="{{ $employer['role'] ?? '' }}"
                                                                           required>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-4 mb-3 formrow">
                                                                    <label class="form-label">Select Country
                                                                        <span style='color:red;'>*</span>
                                                                    </label>
                                                                    <select class="form-control experience-country"
                                                                            data-index="{{ $index }}"
                                                                            name="experience_country_id[{{ $index }}]"
                                                                            required>
                                                                        <option value="">Select Country</option>
                                                                        @foreach($countries as $key => $country)
                                                                            <option value="{{$key}}">{{ $country }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 mb-3 formrow">
                                                                    <label class="form-label">Select
                                                                        State
                                                                        <span style='color:red;'>*</span>
                                                                    </label>
                                                                    <select name="experience_state_id[{{ $index }}]"
                                                                            id="experience_state_id_{{ $index }}"
                                                                            class="form-control experience-state"
                                                                            data-index="{{ $index }}" required>
                                                                        <option value="">Select State</option>
                                                                    </select>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-4 mb-3 formrow">
                                                                    <label class="form-label">Select City
                                                                        <span style='color:red;'>*</span>
                                                                    </label>
                                                                    <select class="form-control experience-city"
                                                                            id="experience_city_id_{{ $index }}"
                                                                            data-index="{{ $index }}"
                                                                            name="experience_city_id[{{ $index }}]"
                                                                            required>
                                                                        
                                                                        <option>Select City</option>
                                                                    </select>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                
                                                                @php
                                                                    // Start Date
                                                                    $fromYear = $employer['from_year'] ?? '';
                                                                    $fromMonth = $employer['from_month'] ?? '';
                                                                    $fromDay = $employer['from_day'] ?? '01';
                                                                    $startDate = ($fromYear && $fromMonth) ? sprintf('%04d-%02d-%02d', $fromYear, $fromMonth, $fromDay) : '';
                                                                
                                                                    // End Date
                                                                    $toYear = $employer['to_year'] ?? '';
                                                                    $toMonth = $employer['to_month'] ?? '';
                                                                    $toDay = $employer['to_day'] ?? '01';
                                                                    $endDate = ($toYear && $toMonth) ? sprintf('%04d-%02d-%02d', $toYear, $toMonth, $toDay) : '';
                                                                @endphp
                                                                
                                                                <div class="col-md-6 mb-3 formrow">
                                                                    <label class="form-label">Experience Start
                                                                        Date
                                                                        <span style='color:red;'>*</span>
                                                                    </label>
                                                                    <input type="date" name="start_date[{{ $index }}]"
                                                                           class="form-control"
                                                                           value="{{ $startDate }}" required>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6 mb-3 formrow">
                                                                    <label class="form-label">Experience End
                                                                        Date</label>
                                                                    <input type="date" name="end_date[{{ $index }}]"
                                                                           class="form-control"
                                                                           value="{{ $endDate }}">
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-12 formrow">
                                                                    <label class="form-label">Currently Working?
                                                                        <span style='color:red;'>*</span>
                                                                    </label>
                                                                    <br>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                               name="currently_working_{{ $index }}"
                                                                               value="1"
                                                                               required
                                                                                {{ ($employer['is_current'] ?? 0) == 1 ? 'checked' : '' }}>
                                                                        <label class="form-check-label">Yes</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                               name="currently_working_{{ $index }}"
                                                                               value="0"
                                                                               required
                                                                                {{ ($employer['is_current'] ?? 0) == 0 ? 'checked' : '' }}>
                                                                        <label class="form-check-label">No</label>
                                                                    </div>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-12 mb-3 formrow">
                                                                    <label class="bold d-block mb-2">Experience
                                                                        Description <span style='color:red;'>*</span>
                                                                    </label>
                                                                    <textarea class="form-control"
                                                                              name="description[{{ $index }}]"
                                                                              rows="3"
                                                                              required>{{  $employer['description'] ?? '' }}</textarea>
                                                                    <div class="invalid-feedback">This field is
                                                                        required.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        
                                        <div class="text-end">
                                            <button class="btn btn-success btn-lg px-4 btn-submit">
                                                <i class="fa fa-save me-2"></i> Save Profile
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {

            $(document).on('change', '.experience-country', function (e) {
                e.preventDefault();

                var index = $(this).data('index');
                var selectedCountry = $(this).val();
                console.log('Country selected for index', index, ':', selectedCountry);

                filterDefaultStatesExperience(index, 0);
            });

            $(document).on('change', '.experience-state', function (e) {
                e.preventDefault();

                var index = $(this).data('index');
                filterDefaultCitiesExperience(index, 0);
            });

            $(document).on('change', '.education-country', function (e) {
                e.preventDefault();

                var index = $(this).data('index');
                var selectedCountry = $(this).val();
                console.log('Country selected for index', index, ':', selectedCountry);

                filterDefaultStatesEducation(index, 0);
            });

            $(document).on('change', '.education-state', function (e) {
                e.preventDefault();

                var index = $(this).data('index');
                filterDefaultCitiesEducation(index, 0);
            });

            $(document).on('click', '.delete-education', function (e) {
                e.preventDefault();

                var $card = $(this).closest('.education-card');

                if ($card.length) {
                    if (confirm('Are you sure you want to remove this education entry?')) {
                        $card.remove();
                    }
                }
            });

            $(document).on('click', '.delete-experience', function (e) {
                e.preventDefault();

                var $card = $(this).closest('.experience-card');

                if ($card.length) {
                    if (confirm('Are you sure you want to remove this experience entry?')) {
                        $card.remove();
                    }
                }
            });

            $(document).on('click', '.btn-submit', function (e) {
                e.preventDefault();

                let allEducationValid = true;
                let allExperienceValid = true;
                let personalInfoValid = true;

                $('.education-card').each(function () {
                    if (!validateCard($(this))) {
                        allEducationValid = false;
                    }
                });

                $('.experience-card').each(function () {
                    if (!validateCard($(this))) {
                        allExperienceValid = false;
                    }
                });

                $('.personal-info-card').each(function () {
                    if (!validateCard($(this))) {
                        personalInfoValid = false;
                    }
                });

                if (!allEducationValid || !allExperienceValid) {
                    const $firstInvalid = $('.is-invalid').first();
                    $('html, body').animate({scrollTop: $firstInvalid.offset().top - 100}, 500);
                    return false;
                }

            });

        });

        function filterDefaultStatesExperience(index, city_id) {
            var country_id = $('.experience-country[data-index="' + index + '"]').val();
            var $stateSelect = $('#experience_state_id_' + index);
            console.log($stateSelect);

            if (country_id) {
                $stateSelect.html('<option>Loading...</option>');

                $.post("{{ route('filter.lang.states.dropdown') }}", {
                    country_id: country_id,
                    state_id: 0,
                    _method: 'POST',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {
                        $stateSelect.html(response);
                    })
                    .fail(function () {
                        $stateSelect.html('<option value="">Failed to load states</option>');
                    });
            }
        }

        function filterDefaultCitiesExperience(index, city_id) {
            var state_id = $('#experience_state_id_' + index).val();
            var $citySelect = $('#experience_city_id_' + index);

            if (state_id !== '') {
                $citySelect.html('<option>Loading...</option>');

                $.post("{{ route('filter.lang.cities.dropdown') }}", {
                    state_id: state_id,
                    city_id: city_id,
                    _method: 'POST',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {
                        $citySelect.html(response);
                    })
                    .fail(function () {
                        $citySelect.html('<option value="">Failed to load states</option>');
                    });
            }
        }

        function filterDefaultStatesEducation(index, city_id) {
            var country_id = $('.education-country[data-index="' + index + '"]').val();
            var $stateSelect = $('#education_state_id_' + index);
            console.log($stateSelect);

            if (country_id) {
                $stateSelect.html('<option>Loading...</option>');

                $.post("{{ route('filter.lang.states.dropdown') }}", {
                    country_id: country_id,
                    state_id: 0,
                    _method: 'POST',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {
                        $stateSelect.html(response);
                    })
                    .fail(function () {
                        $stateSelect.html('<option value="">Failed to load states</option>');
                    });
            }
        }

        function filterDefaultCitiesEducation(index, city_id) {
            var state_id = $('#education_state_id_' + index).val();
            var $citySelect = $('#education_city_id_' + index);

            if (state_id !== '') {
                $citySelect.html('<option>Loading...</option>');

                $.post("{{ route('filter.lang.cities.dropdown') }}", {
                    state_id: state_id,
                    city_id: city_id,
                    _method: 'POST',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {
                        $citySelect.html(response);
                    })
                    .fail(function () {
                        $citySelect.html('<option value="">Failed to load states</option>');
                    });
            }
        }

        function validateCard($card) {
            let valid = true;

            $card.find('input, select, textarea').each(function () {
                if ($(this).prop('required') && !$(this).val()) {
                    valid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            return valid;
        }
    
    </script>

@endpush
