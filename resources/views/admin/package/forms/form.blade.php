{!! APFrmErrHelp::showOnlyErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_title') !!}"> {!! Form::label('package_title', 'Package Title', ['class' => 'bold']) !!}
        {!! Form::text('package_title', null, array('class'=>'form-control', 'id'=>'package_title', 'placeholder'=>'Package Title')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_title') !!} </div>
    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_price') !!}"> {!! Form::label('package_price', 'Package Price(In USD)', ['class' => 'bold']) !!}
        {!! Form::text('package_price', null, array('class'=>'form-control','onkeypress'=>'return isNumberKey(event)', 'id'=>'package_price', 'placeholder'=>'Package Price')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_price') !!} </div>
    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_num_days') !!}"> {!! Form::label('package_num_days', 'Package num days', ['class' => 'bold']) !!}
        {!! Form::text('package_num_days', null, array('class'=>'form-control','onkeypress'=>'return isNumberKey(event)', 'id'=>'package_num_days', 'placeholder'=>'Package num days')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_num_days') !!} </div>
    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_sequence') !!}"> {!! Form::label('package_sequence', 'Package Sequence', ['class' => 'bold']) !!}
        {!! Form::text('package_sequence', null, array('class'=>'form-control','onkeypress'=>'return isNumberKey(event)',  'id'=>'package_sequence', 'placeholder'=>'Package Sequence')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_sequence') !!} </div>
    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_num_listings') !!}"> {!! Form::label('package_num_listings', 'Package num listings*', ['class' => 'bold']) !!}
        {!! Form::text('package_num_listings', null, array('class'=>'form-control','onkeypress'=>'return isNumberKey(event)', 'id'=>'package_num_listings', 'placeholder'=>'Package num listings')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_num_listings') !!}
    </div>
    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_resume_downloads') !!}"> {!! Form::label('package_resume_downloads', 'Package resume downloads*', ['class' => 'bold']) !!}
        {!! Form::text('package_resume_downloads', null, array('class'=>'form-control','onkeypress'=>'return isNumberKey(event)', 'id'=>'package_resume_downloads', 'placeholder'=>'Package resume downloads')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_resume_downloads') !!}
    </div>
    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_cv_searches') !!}"> {!! Form::label('package_cv_searches', 'Package cv searches*', ['class' => 'bold']) !!}
        {!! Form::text('package_cv_searches', null, array('class'=>'form-control','onkeypress'=>'return isNumberKey(event)', 'id'=>'package_cv_searches', 'placeholder'=>'Package cv searches')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_cv_searches') !!}
    </div>
    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_users_limit') !!}"> {!! Form::label('package_users_limit', 'Package users limit*', ['class' => 'bold']) !!}
        {!! Form::text('package_users_limit', null, array('class'=>'form-control','onkeypress'=>'return isNumberKey(event)', 'id'=>'package_users_limit', 'placeholder'=>'Package users limit')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_users_limit') !!}
    </div>
    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_for') !!}">
        {!! Form::label('package_for', 'Package for?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $package_for_1 = 'checked="checked"';
            $package_for_2 = '';
            $package_for_3 = '';
            if (old('package_for', ((isset($package)) ? $package->package_for : 'job_seeker')) == 'employer') {
                $package_for_1 = '';
                $package_for_2 = 'checked="checked"';
                $package_for_3 = '';
            }
            ?>
            <label class="radio-inline">
                <input id="job_seeker" name="package_for" type="radio" value="job_seeker" {{$package_for_1}}>
                Job Seeker </label>
            <label class="radio-inline">
                <input id="employer" name="package_for" type="radio" value="employer" {{$package_for_2}}>
                Employer </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'package_for') !!}
    </div>
    <div class="form-actions"> {!! Form::button('Update <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')) !!} </div>
</div>

<script type="text/javascript">
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>