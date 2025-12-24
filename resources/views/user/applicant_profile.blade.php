@extends('layouts.app')

@section('content')
    @include('includes.header')
    @include('includes.inner_page_title', ['page_title' => __($page_title)])
    
    @php
        $true = false;
        $authCompany = Auth::guard('company')->user()?->company;
        if ($authCompany) {
            $array_ids = explode(',', $authCompany->availed_cvs_ids ?? '');
            if (in_array($user->id, $array_ids)) {
                $true = true;
            }
        }
    @endphp
    
    <div class="listpgWraper">
        <div class="container">
            @include('flash::message')
            
            {{-- Cover + User Info --}}
            <div class="usercoverimg">
                <div class="coverImageWrapper">
                    {!! $user->printUserCoverImage() !!}
                </div>
                <div class="userMaininfo">
                    <div class="userPic">{{ $user->printUserImage() }}</div>
                    <div class="title">
                        <h3>
                            {{ $user->getName() }}
                            @if($user->is_immediate_available)
                                <span>{{ __('Immediate Available For Work') }}</span>
                            @endif
                        </h3>
                        <div class="desi"><i class="fa fa-map-marker"></i> {{ $user->getLocation() }}</div>
                        <div class="membersinc"><i class="fa fa-history"></i> {{ __('Member Since') }},
                            {{ $user->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>
            
            {{-- Action Buttons --}}
            <div class="userlinkstp">
                @if($true)
                    @if(isset($job, $company))
                        @if($authCompany && $authCompany->isHiredApplicant($user->id, $job->id, $company->id))
                            <a href="{{ route('remove.hire.from.favourite.applicant', [$job_application->id, $user->id, $job->id, $company->id]) }}"
                               class="btn"><i class="fa fa-floppy-o"></i> {{ __('Not Hired') }}</a>
                        @else
                            @if($authCompany && $authCompany->isFavouriteApplicant($user->id, $job->id, $company->id))
                                <a href="{{ route('remove.from.favourite.applicant', [$job_application->id, $user->id, $job->id, $company->id]) }}"
                                   class="btn"><i class="fa fa-floppy-o"></i> {{ __('Not Shortlisted') }}</a>
                                <a href="{{ route('hire.from.favourite.applicant', [$job_application->id, $user->id, $job->id, $company->id]) }}"
                                   class="btn"><i class="fa fa-floppy-o"></i> {{ __('Hire This Candidate') }}</a>
                            @else
                                <a href="{{ route('add.to.favourite.applicant', [$job_application->id, $user->id, $job->id, $company->id]) }}"
                                   class="btn"><i class="fa fa-floppy-o"></i> {{ __('Shortlist') }}</a>
                            @endif
                        @endif
                        <a href="{{ route('reject.applicant.profile', [$job_application->id]) }}"
                           class="btn btn-warning"><i class="fa fa-floppy-o"></i> {{ __('Reject') }}</a>
                    @endif
                    
                    @php
                        $maxDownloads = $authCompany->download_resume_quota ?? 0;
                    @endphp
                    @if($authCompany && $authCompany->availed_download_resume_quota < $maxDownloads)
                        @if($profileCv)
                            <a href="{{ asset('cvs/'.$profileCv->cv_file) }}" class="btn" onclick="incrementQuota()">
                                <i class="fa fa-download"></i> {{ __('Download CV') }}
                            </a>
                        @endif
                    @else
                        <button class="btn btn-default" disabled>{{ __('Download CV Quota Exceeded') }}</button>
                    @endif
                    
                    <a href="javascript:" onclick="send_message()" class="btn"><i
                                class="fa fa-envelope"></i> {{ __('Send Message') }}</a>
                @endif
                
                @if($authCompany && !$true)
                    <a href="{{ route('company.unlock', $user->id) }}" class="btn btn-default report"><i
                                class="fa fa-lock"></i> {{ __('Profile Locked') }}</a>
                    <span>Unlock profile to view candidate CV and contact details</span>
                @endif
            </div>
            
            {{-- Profile Content --}}
            <div class="row">
                <div class="col-md-8">
                    {{-- About --}}
                    <div class="job-header">
                        <div class="contentbox">
                            <h3>{{ __('About me') }}</h3>
                            <p>{{ $user->getProfileSummary('summary') }}</p>
                        </div>
                        <div class="ptsklbx">
                            <h3 class="skills_heading">{{ __('Skills') }}</h3>
                            <div id="skill_div"></div>
                        </div>
                    </div>
                    
                    {{-- Video --}}
                    @if(!empty($user->video_link))
                        <div class="job-header">
                            <div class="contentbox">
                                <h3>{{ __('Video Profile') }}</h3>
                                <iframe src="{{ $user->video_link }}" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif
                    
                    {{-- Experience --}}
                    <div class="job-header">
                        <div class="contentbox">
                            <h3 class="experince_heading">{{ __('Experience') }}</h3>
                            <div id="experience_div"></div>
                        </div>
                    </div>
                    
                    {{-- Education --}}
                    <div class="job-header">
                        <div class="contentbox">
                            <h3 class="education_heading">{{ __('Education') }}</h3>
                            <div id="education_div"></div>
                        </div>
                    </div>
                    
                    {{-- Languages --}}
                    <div class="job-header">
                        <div class="contentbox">
                            <h3 class="language_container">{{ __('Languages') }}</h3>
                            <div id="language_div"></div>
                        </div>
                    </div>
                    
                    {{-- Portfolio --}}
                    <div class="job-header">
                        <div class="contentbox">
                            <h3 class="project_heading">{{ __('Portfolio') }}</h3>
                            <div id="projects_div"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    {{-- Contact (only if unlocked) --}}
                    @if($true)
                        <div class="job-header">
                            <div class="jobdetail">
                                <h3>{{ __('Candidate Contact') }}</h3>
                                <div class="candidateinfo">
                                    @if($user->phone)
                                        <div class="loctext"><i class="fa fa-phone"></i> <a
                                                    href="tel:{{ $user->phone }}">{{ $user->phone }}</a></div>
                                    @endif
                                    @if($user->mobile_num)
                                        <div class="loctext"><i class="fa fa-mobile"></i> <a
                                                    href="tel:{{ $user->mobile_num }}">{{ $user->mobile_num }}</a></div>
                                    @endif
                                    @if($user->email)
                                        <div class="loctext"><i class="fa fa-envelope"></i> <a
                                                    href="mailto:{{ $user->email }}">{{ $user->email }}</a></div>
                                    @endif
                                    <div class="loctext"><i class="fa fa-map-marker"></i> {{ $user->street_address }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    {{-- Candidate Detail --}}
                    <div class="job-header">
                        <div class="jobdetail">
                            <h3>{{ __('Candidate Detail') }}</h3>
                            <ul class="jbdetail">
                                <li class="row">
                                    <div class="col-md-6">Is Email Verified</div>
                                    <div class="col-md-6"><span>{{$user->verified ? 'Yes':'No'}}</span></div>
                                </li>
                                <li class="row">
                                    <div class="col-md-6">Immediate Available</div>
                                    <div class="col-md-6">
                                        <span>{{  $user->is_immediate_available ? 'Yes' : 'No' }}</span>
                                    </div>
                                </li>
                                <li class="row">
                                    <div class="col-md-6">Age</div>
                                    <div class="col-md-6"><span>{{ $user->getAge() }} Years</span></div>
                                </li>
                                <li class="row">
                                    <div class="col-md-6">Gender</div>
                                    <div class="col-md-6"><span>{{ $user->getGender('gender') }}</span></div>
                                </li>
                                <li class="row">
                                    <div class="col-md-6">Marital Status</div>
                                    <div class="col-md-6"><span>{{ $user->getMaritalStatus('marital_status') }}</span>
                                    </div>
                                </li>
                                <li class="row">
                                    <div class="col-md-6">Experience</div>
                                    <div class="col-md-6"><span>{{ $user->getJobExperience('job_experience') }}</span>
                                    </div>
                                </li>
                                <li class="row">
                                    <div class="col-md-6">Career Level</div>
                                    <div class="col-md-6"><span>{{ $user->getCareerLevel('career_level') }}</span></div>
                                </li>
                                <li class="row">
                                    <div class="col-md-6">Notice Period</div>
                                    <div class="col-md-6"><span>{{ $user->notice_period }} days</span></div>
                                </li>
                                
                                {{-- Salary --}}
                                @if(Auth::check() && Auth::id() === $user->id || !$user->hide_salary)
                                    <li class="row">
                                        <div class="col-md-6">Current Salary</div>
                                        <div class="col-md-6">
                                            <span>{{ $user->current_salary }} {{ $user->salary_currency }}</span></div>
                                    </li>
                                    <li class="row">
                                        <div class="col-md-6">Expected Salary</div>
                                        <div class="col-md-6">
                                            <span>{{ $user->expected_salary }} {{ $user->salary_currency }}</span></div>
                                    </li>
                                @endif
                                
                                {{-- Questions --}}
                                @php
                                    $all_questions = [];
                                    if (!empty($job_application?->data)) {
                                        $JSON = json_decode($job_application->data);
                                        if ($JSON && count($JSON) > 0) {
                                            $all_questions = $JSON;
                                        }
                                    }
                                @endphp
                                @if(!empty($all_questions))
                                    <li class="row">
                                        <div class="col-md-12">Question and Their Answers</div>
                                        <div class="col-md-12">
                                            @foreach($all_questions as $question)
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <span class="freelance">{{ $question->question }}</span>
                                                        @if($question->question_type === "text")
                                                            <p style="word-break: break-all;">{{ $question->answer }}</p>
                                                        @elseif($question->question_type === "video")
                                                            <video width="320" height="240" controls>
                                                                <source src="{{ asset('question_answer_videos/'.$question->video_name) }}"
                                                                        type="video/mp4">
                                                            </video>
                                                        @endif
                                                    </div>
                                                </div>
                                                <br>
                                            @endforeach
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Message Modal --}}
    <div class="modal fade" id="sendmessage" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="send-form">
                    @csrf
                    <input type="hidden" name="seeker_id" value="{{ $user->id }}">
                    <div class="modal-header">
                        <h4 class="modal-title">Send Message</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" name="message" rows="7"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @include('includes.footer')
@endsection

@push('styles')
    <style>
        .formrow iframe {
            height: 78px;
        }

        .coverImageWrapper img {
            width: 1140px;
            height: 243px;
            object-fit: cover;
            display: block;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function incrementQuota() {
            axios.post("{{ route('viewed.cvs') }}")
                .then(res => console.log(res.data))
                .catch(err => console.error(err));
        }

        $(document).ready(function () {
            $(document).on('click', '#send_applicant_message', function () {
                var postData = $('#send-applicant-message-form').serialize();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('contact.applicant.message.send') }}",
                    data: postData,
                    //dataType: 'json',
                    success: function (data) {
                        response = JSON.parse(data);
                        var res = response.success;
                        if (res == 'success') {
                            var errorString = '<div role="alert" class="alert alert-success">' + response.message + '</div>';
                            $('#alert_messages').html(errorString);
                            $('#send-applicant-message-form').hide('slow');
                            $(document).scrollTo('.alert', 2000);
                        } else {
                            var errorString = '<div class="alert alert-danger" role="alert"><ul>';
                            response = JSON.parse(data);
                            $.each(response, function (index, value) {
                                errorString += '<li>' + value + '</li>';
                            });
                            errorString += '</ul></div>';
                            $('#alert_messages').html(errorString);
                            $(document).scrollTo('.alert', 2000);
                        }
                    },
                });
            });
            showEducation();
            showProjects();
            showExperience();
            showSkills();
            showLanguages();
        });

        function showProjects() {
            $.post("{{ route('show.applicant.profile.projects', $user->id) }}", {
                user_id: {{$user->id}},
                _method: 'POST',
                _token: '{{ csrf_token() }}'
            })
                .done(function (response) {
                    $('#projects_div').html(response);
                    if ($("ul.userPortfolio li").length == 0) {
                        $(".project_heading").hide();
                    }
                });
        }

        function showExperience() {
            $.post("{{ route('show.applicant.profile.experience', $user->id) }}", {
                user_id: {{$user->id}},
                _method: 'POST',
                _token: '{{ csrf_token() }}'
            })
                .done(function (response) {
                    $('#experience_div').html(response);
                    if ($("ul.experienceList li").length == 0) {
                        $(".experince_heading").hide();
                    }
                });
        }

        function showEducation() {
            $.post("{{ route('show.applicant.profile.education', $user->id) }}", {
                user_id: {{$user->id}},
                _method: 'POST',
                _token: '{{ csrf_token() }}'
            })
                .done(function (response) {
                    $('#education_div').html(response);
                    if ($("ul.educationList li").length == 0) {
                        $(".education_heading").hide();
                    }
                });
        }

        function showLanguages() {
            $.post("{{ route('show.applicant.profile.languages', $user->id) }}", {
                user_id: {{$user->id}},
                _method: 'POST',
                _token: '{{ csrf_token() }}'
            })
                .done(function (response) {
                    $('#language_div').html(response);
                    if ($("#language_div").find("tr").length == 0) {
                        $(".language_container").hide();
                    }
                });
        }

        function showSkills() {
            $.post("{{ route('show.applicant.profile.skills', $user->id) }}", {
                user_id: {{$user->id}},
                _method: 'POST',
                _token: '{{ csrf_token() }}'
            })
                .done(function (response) {
                    $('#skill_div').html(response);
                    if ($("ul.profileskills li").length == 0) {
                        $(".skills_heading").hide();
                    }
                });
        }

        function send_message() {
            const el = document.createElement('div')
            el.innerHTML = "Please <a class='btn' href='{{route('login')}}' onclick='set_session()'>log in</a> as a Employer and try again."
            @if(null!==(Auth::guard('company')->user()))
            $('#sendmessage').modal('show');
            @else
            swal({
                title: "You are not Loged in",
                content: el,
                icon: "error",
                button: "OK",
            });
            @endif
        }

        if ($("#send-form").length > 0) {
            $("#send-form").validate({
                validateHiddenInputs: true,
                ignore: "",

                rules: {
                    message: {
                        required: true,
                        maxlength: 5000
                    },
                },
                messages: {

                    message: {
                        required: "Message is required",
                    }

                },
                submitHandler: function (form) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    @if(null !== (Auth::guard('company')->user()))
                    $.ajax({
                        url: "{{route('submit-message-seeker')}}",
                        type: "POST",
                        data: $('#send-form').serialize(),
                        success: function (response) {
                            $("#send-form").trigger("reset");
                            $('#sendmessage').modal('hide');
                            swal({
                                title: "Success",
                                text: response["msg"],
                                icon: "success",
                                button: "OK",
                            });
                        }
                    });
                    @endif
                }
            })
        }
    </script>
@endpush