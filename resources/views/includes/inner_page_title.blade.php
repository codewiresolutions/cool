<div class="pageTitle">
    
    <div class="container">
        <div class="row">
            
            <div class="col-md-3 col-sm-3">
                <h1 class="page-heading">{{$page_title}}</h1>
            </div>
            @if(@$page_title == 'Dashboard')
                <div class="col-md-9 col-sm-9">
                @if(Auth::guard('company')->check())
                <form action="{{route('job.seeker.list')}}" method="get">
                    <div class="searchform row custom_top_margin_second_header">
                        <div class="col-lg-9">
                            <input type="text" name="search" id="functional_find" value="{{Request::get('search', '')}}" class="form-control" placeholder="{{__('Search Role...')}}" />
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i> {{__('Search')}}</button>
                        </div>
                    </div>
                </form>
            @endif
            @elseif(@$page_title == 'Job Applicants')
            <div class="col-md-9 col-sm-9">
                @if(Auth::guard('company')->check())
                <form action="{{route('job.seeker.list')}}" method="get">
                    <div class="searchform row custom_top_margin_second_header">
                        <div class="col-lg-3">
                            <input type="text" name="job_title_filter" id="job_title_autocomplete" value="{{Request::get('job_title_filter', '')}}" class="form-control" placeholder="{{__('Filter Job Skill...')}}" autocomplete="off" />
                            <div id="job_title_results" style="position: absolute; z-index: 1000; width: 90%; background: #fff; border: 1px solid #ccc; display: none;"></div>
                        </div>
                        <div class="col-lg-3">
                            <input type="text" name="search" id="functional_find" value="{{Request::get('search', '')}}" class="form-control" placeholder="{{__('Search Role...')}}" />
                        </div>
                        <div class="col-lg-3 pl-lg-0">
                        <select name="country_id[]" class="form-control" style="background-color: #0096ff; color:white">
                            <option value="">Select Country</option>
                            @php
                                $countries = App\Country::whereIn('country_id', $countryIdsArray)
                                    ->lang()
                                    ->active()
                                    ->orderBy('country') // Order by the 'country' column
                                    ->get();
                            @endphp
                            @foreach ($countries as $country)
                                @php
                                      $selected = (in_array($country->country_id, Request::get('country_id', array()))) ? 'selected' : '';
                                @endphp
                                <option value="{{ $country->country_id  }}" {{ $selected }}>{{ $country->country  }}</option>
                            @endforeach
                        </select>
                    </div>
{{--                    <div class="col-lg-2 pl-lg-0">--}}
{{--                        <select name="job_experience_id[]" class="form-control find_job" style="background-color: #0096ff; color: white">--}}
{{--                            <option value="">Experience</option>--}}
{{--                            @php--}}
{{--                                $jobExperiences = App\JobExperience::whereIn('job_experience_id', $jobExperienceIdsArray)--}}
{{--                                    ->lang()--}}
{{--                                    ->active()--}}
{{--                                    ->orderBy('job_experience') // Order by the 'job_experience' column--}}
{{--                                    ->get();--}}

{{--                            @endphp--}}
{{--                            @foreach ($jobExperiences as $jobExperience)--}}
{{--                            @php--}}
{{--                                $selected = (in_array($jobExperience->job_experience_id, Request::get('job_experience_id', array()))) ? 'selected' : '';--}}
{{--                            @endphp--}}
{{--                                <option value="{{ $jobExperience->job_experience_id  }}" {{ $selected }}>{{ $jobExperience->job_experience  }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
                        <div class="col-lg-3">
                            <button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i> {{__('Search')}}</button>
                        </div>
                    </div>
                </form>
                @else
                <form action="{{route('company.listing')}}" method="get">
                    <div class="searchform row custom_top_margin_second_header">
                        <div class="col-lg-9">
                            <input type="text" name="search" value="{{Request::get('search', '')}}" class="form-control typeahead typeahead_company" placeholder="{{__('Enter Skills, job title or Location')}}" />
                        </div>

                        <div class="col-lg-3">
                            <button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i> {{__('Search Jobs')}}</button>
                        </div>
                    </div>
                </form>
                @endif
            </div>
            @endif
        </div>
    </div>
    
</div>
    
    
@push('scripts')
<script>
    $(document).ready(function() {
        var $input = $('#job_title_autocomplete');
        var $results = $('#job_title_results');

        $input.on('keyup', function() {
            var query = $(this).val();
            if (query.length >= 2) {
                $.ajax({
                    url: "{{ route('filter.job.title') }}/" + query,
                    type: 'GET',
                    success: function(data) {
                        $results.empty().show();
                        if (data.length > 0) {
                            $.each(data, function(index, item) {
                                $results.append('<div class="search-item" style="padding: 8px; cursor: pointer; border-bottom: 1px solid #eee;">' + item.title + '</div>');
                            });
                        } else {
                            $results.hide();
                        }
                    }
                });
            } else {
                $results.hide();
            }
        });

        $(document).on('click', '.search-item', function() {
            $input.val($(this).text());
            $results.hide();
            // Optional: Auto-submit form on selection
            // $input.closest('form').submit();
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#job_title_autocomplete, #job_title_results').length) {
                $results.hide();
            }
        });
    });
</script>
@endpush