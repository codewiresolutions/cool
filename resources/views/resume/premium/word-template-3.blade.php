<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>  <table>
    
        <tr><td style="width:50px"></td>
        <td><p style="font-size: 25px; font-family:Arial; text-align:center; color:24779A; font-weight:bold">{{ $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name }}<img src="{{asset('/word-icons/word6-border-1.png')}}" height="3" width="745" alt=""> </p></td></tr>  
           
          <tr>  @if(@isset($user->email) || @isset($user->mobile_num) || isset($user->country) || isset($user->state) || isset($user->city))<p style="color:#24779A; font-size:15px; text-align:center; font-family:Arial">{{ $user->email .' | ' . $user->mobile_num .' | ' . $user->city . ', ' . $user->country }}</p>@endisset
           
            <tr><td style="width:50px"></td><td><p style="font-size:14px; text-align:center; width:500px ">{{ $user->getProfileSummary('summary') }}</p></td></tr>

        
    </tr>

 

     
     <tr>           @if($user->getProfileSummary('summary'))<p style="font-size: 18px; font-family:Arial; color:white; line-height:1; padding:0; margin:0; background-color:#24779A; text-align:center">PROFESSIONAL EXPERIENCE</p></tr>
</table>
                  <table>
                  @foreach($user_experience as $user_exp)
                        <tr><td style="width:800px"><p style="font-size: 11pt; margin:0; padding:0; text-align:center">{{ $user_exp->title }}</p></td></tr>
                        <tr><td><p style="font-size: 11pt; margin:0; padding:0; text-align:center"><b>{{ $user_exp->company . ', ' . $user_exp->city_name }}</b></p></td></tr>

            <tr><td><p style="font-size: 9pt; font-align:right; margin:0; padding:0; text-align:center">{{'From '.date('d M, Y', strtotime($user_exp->date_start)).' - ' }}@if($user_exp->date_end){{date('d M, Y', strtotime($user_exp->date_end))}}@else<?php ?>Currently Working<?php ?>@endif @php
                            $total_years = 0;
                            $total_months = 0;
                            $start_date = $user_exp->date_start;
                            $end_date = $user_exp->date_end != null ? $user_exp->date_end : \Carbon\Carbon::now();
                            $start = \Carbon\Carbon::parse($start_date);
                            $end = \Carbon\Carbon::parse($end_date);
                            $years = $end->diffInYears($start);
                            $months = $end->diffInMonths($start) % 12;
                            $total_years += $years;
                            $total_months += $months;
                            if ($end->day >= $start->day) {
                                $total_months += 1;
                            }
                            $total_years += intdiv($total_months, 12);
                            $total_months %= 12;
                        @endphp- <b>@if($total_years || $total_months)@if($total_years==1){{$total_years}}@if($total_months){{'.'.$total_months}}@endif Year @elseif($total_years > 1){{ $total_years }}@if($total_months){{ '.' . $total_months . ' Years' }}@else Years @endif @else @if($total_months == 1){{ $total_months . ' Month' }}@else{{ $total_months . ' Months' }}@endif @endif @endif</b></p></td>td
                        </tr>
                        
                            <tr><td><ul><li><p style="font-size: 10pt; line-height:1;">{{$user_exp->description}}</p></li></ul></td></tr>
                    <tr><td></td></tr>   
                          
                          
                    @endforeach
<tr>
@if(count($user_projects) > 0))<p style="font-size: 18px; font-family:Arial; color:white; line-height:1; padding:0; margin:0; background-color:#24779A; text-align:center">PROJECTS</p>
</tr>
</table>
<table>
  @foreach($user_projects as $project)
  <tr><td></td></tr>
  <tr><td style="width:800px"><p style="font-size: 11pt; margin:0; padding:0; text-align:center"><b>{{ $project->name }}</b></p></td></tr>
  <tr><td><p style="font-size: 11pt; margin:0; padding:0; text-align:center">{{ $project->url }}</p></td></tr>
  <tr><td><p style="font-size: 11pt; margin:0; padding:0; text-align:center">{{ date('M, Y', strtotime($project->date_start)) . ' - ' . date('M, Y', strtotime($project->date_end)) }}</p></td></tr>
  <tr><td><ul><li><p style="font-size: 10pt; line-height:1;">{{$project->description}}</p></li></ul></td></tr>                          
                            @endforeach
                @endif

               
                <tr>
@if(count($user_educations) > 0))<p style="font-size: 18px; font-family:Arial; color:white; line-height:1; padding:0; margin:0; background-color:#24779A; text-align:center">EDUCATION</p>
</tr>
</table>
<table>
@foreach($user_educations as $user_edu)
<tr><td></td></tr>
<tr><td style="width:900px"><p style="font-size: 11pt; margin:0; padding:0; text-align:center">{{ $user_edu->institution .', '. $user_edu->city }}</p></td></tr>
<tr><td><p style="font-size: 11pt; margin:0; padding:0; text-align:center">{{ $user_edu->date_completion}}</p></td></tr>
<tr><td><p style="font-size: 11pt; margin:0; padding:0; text-align:center"><b>{{ $user_edu->degree_level}}</b></p></td></tr>

                                     
                @endforeach
                @endif

                <tr><td></td></tr><tr>
@if(count($user_skills) > 0))<p style="font-size: 18px; font-family:Arial; color:white; line-height:1; padding:0; margin:0; background-color:#24779A; text-align:center">SKILLS</p>
</tr>
</table>
<table>
@foreach($user_skills as $user_skill)
<tr><td><ul style="text-align:center">
<li style="text-align:center"><p style="font-size: 10pt; line-height:1">{{ $user_skill->job_skill }} - <span style="color:#24779A;">{{ $user_skill->job_experience }}</span></p></li>@endforeach
</ul></td></tr>

                           
                @endif

                <tr>
@if(count($user_languages) > 0))
<p style="font-size: 18px; font-family:Arial; color:white; line-height:1; padding:0; margin:0; background-color:#24779A; text-align:center">LANGUAGES</p>
</tr>
</table>
<table>
@foreach($user_languages as $user_language)
<tr><td><ul style="text-align:center">
<li style="text-align:center"><p style="font-size: 10pt; line-height:1">{{ $user_language->lang }} - <span style="color:#24779A;">{{ $user_language->language_level }}</span></p></li>@endforeach
</ul></td></tr>

                           
                @endif
                
                </table>


                <tr>
  
  <td style="width:35px;"></td>

@if (isset($user->father_name) ||
  isset($user->date_of_birth) ||
  isset($user->gender_id) ||
  isset($user->marital_status_id) ||
  isset($user->nationality_id) ||
  isset($user->national_id_card_number) ||
  isset($user->phone) ||
  isset($user->job_experience) ||
  isset($user->industry) ||
  isset($user->functional_area) ||
  isset($user->current_salary) ||
  isset($user->expected_salary) ||
  isset($user->salary_currency) ||
  isset($user->street_address) ||
  isset($user->video_link))<p style="font-size: 18px; font-family:Arial; color:white; line-height:1; padding:0; margin:0; background-color:#24779A; text-align:center">PERSONAL INFORMATION</p><table>
  @isset($user->father_name)
  
  <tr><td style="width:40px"></td><td><p style="font-size: 11pt; margin:0; padding:0">Father Name :</p></td>
          <td><p style="font-size: 11pt; margin:0; padding:0;">{{ $user->father_name }}</p></td>
      </tr>
  @endisset
  @isset($user->date_of_birth)
      <tr>
      <td style="width:40px"></td><td><p style="font-size: 11pt; margin:0; padding:0;">Date of Birth :</p></td>
          <td><p style="font-size: 11pt; margin:0; padding:0;">{{ date('d F, Y', strtotime($user->date_of_birth)) }}</p></td>
      </tr>
  @endisset
  @isset($user->gender_id)
      <tr>
      <td style="width:40px"></td><td><p style="font-size: 11pt; margin:0; padding:0;">Gender :</p></td>
          <td><p style="font-size: 11pt; margin:0; padding:0;">{{ $user->gender }}</p></td>
      </tr>
  @endisset
  @isset($user->marital_status)
      <tr>
      <td style="width:40px"></td><td><p style="font-size: 11pt; margin:0; padding:0;">Marital Status :</p></td>
          <td><p style="font-size: 11pt; margin:0; padding:0;">{{ $user->marital_status }}</p></td>
      </tr>
  @endisset
  @isset($user->nationality)
      <tr>
      <td style="width:40px"></td><td><p style="font-size: 11pt; margin:0; padding:0;">Nationality :</p></td>
          <td><p style="font-size: 11pt; margin:0; padding:0;">{{ $user->nationality }}</p></td>
      </tr>
  @endisset
  @isset($user->job_experience)
      <tr>
      <td style="width:40px"></td><td><p style="font-size: 11pt; margin:0; padding:0;">Job Experience :</p></td>
          <td><p style="font-size: 11pt; margin:0; padding:0;">{{ $user->job_experience }}</p></td>
      </tr>
  @endisset
  @isset($user->industry)
      <tr>
      <td style="width:40px"></td><td><p style="font-size: 11pt; margin:0; padding:0;">Industry :</p></td>
          <td><p style="font-size: 11pt; margin:0; padding:0;">{{ $user->industry }}</p></td>
      </tr>
  @endisset
  @isset($user->functional_area)
      <tr>
      <td style="width:40px"></td><td><p style="font-size: 11pt; margin:0; padding:0;">Functional Area :</p></td>
          <td><p style="font-size: 11pt; margin:0; padding:0;">{{ $user->functional_area }}</p></td>
      </tr>
  @endisset
  @isset($user->video_link)
      <tr>
      <td style="width:40px"></td><td><p style="font-size: 11pt; margin:0; padding:0;">Video Profile :</p></td>
          <td><p style="font-size: 11pt; margin:0; padding:0;">{{ $user->video_link }}</p></td>
      </tr>
  @endisset

  <tr><td></td></tr>
  </table>

@endif






                    
               @endif
          <tr><td></td></tr>
                
  
</body>
</html>