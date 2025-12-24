<div class="modal-body">
    <div class="form-body">
<div class="row">
        <div class="formrow col-md-6" id="div_job_skill_id">
            @php
                $job_skill_id = isset($profileSkill) ? $profileSkill->job_skill_id : null;
            @endphp
            {!! Form::select('job_skill_id', [''=>__('Select Skill')]+$jobSkills, $job_skill_id, [
                'class' => 'form-control',
                'id' => 'job_skill_id'
            ]) !!}
            <span class="help-block job_skill_id-error text-danger"></span>
        </div>

        <p id="if_skill_already_exists" class="text-danger mb-3"></p>

        <div class="formrow col-md-6" id="div_job_experience_id">
            @php
                $job_experience_id = isset($profileSkill) ? $profileSkill->job_experience_id : null;
            @endphp
            {!! Form::select('job_experience_id', [''=>__('Select Experience')]+$jobExperiences, $job_experience_id, [
                'class' => 'form-control',
                'id' => 'job_experience_id'
            ]) !!}
            <span class="help-block job_experience_id-error text-danger"></span>
        </div>
            </div>
    </div>
</div>
