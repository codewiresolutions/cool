<div class="modal-body">
    <div class="form-body">
        <div class="row">
            <div class="form-group col-md-6" id="div_language_id">
               
                <?php $language_id = isset($profileLanguage) ? $profileLanguage->language_id : null; ?>
                {!! Form::select('language_id', [''=>'Select language'] + $languages, $language_id, ['class'=>'form-control', 'id'=>'language_id']) !!}
                <span class="help-block language_id-error text-danger"></span>
            </div>

            <div class="form-group col-md-6" id="div_language_level_id">
                
                <?php $language_level_id = isset($profileLanguage) ? $profileLanguage->language_level_id : null; ?>
                {!! Form::select('language_level_id', [''=>'Select Language Level'] + $languageLevels, $language_level_id, ['class'=>'form-control', 'id'=>'language_level_id']) !!}
                <span class="help-block language_level_id-error text-danger"></span>
            </div>
        </div>
    </div>
</div> 
