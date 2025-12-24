<div class="modal-body">
    <div class="form-body">

        <div class="formrow" id="div_title">
            <input class="form-control" id="title" placeholder="{{ __('CV Title') }}" name="title" type="text"
                   value="{{ isset($profileCv) ? $profileCv->title : '' }}">
            <span class="help-block title-error text-danger"></span>
        </div>

        @if(isset($profileCv))
            <div class="formrow">
                {{ ImgUploader::print_doc("cvs/$profileCv->cv_file", $profileCv->title, $profileCv->title) }}
            </div>
        @endif

        <div class="formrow" id="div_cv_file">
            <div class="row">
                <div class="col-md-6">
                    <input name="cv_file" id="cv_file" type="file" class="form-control" />
                </div>
                <div class="col-md-3 px-1 mx-0">
              <a href="{{ url('/resume-builder') }}" target="_blank"  class="btn btn-primary my-0">Use Our Template</a>
                </div>
            </div>

            <span class="help-block cv_file-error text-danger"></span>
        </div>

        <div class="formrow" id="div_is_default">
            <label for="is_default" class="bold d-block mb-2">{{ __('Is Default?') }}</label>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_default" id="default" value="1"
                                {{ isset($profileCv) && $profileCv->is_default == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="default">{{ __('Yes') }}</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_default" id="not_default" value="0"
                                {{ isset($profileCv) && $profileCv->is_default == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="not_default">{{ __('No') }}</label>
                    </div>
                </div>
            </div>
            <span class="help-block is_default-error text-danger"></span>
        </div>

    </div>
</div>
