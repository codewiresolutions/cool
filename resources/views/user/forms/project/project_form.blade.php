<div class="modal-body">
    <div class="form-body">
        
        <div class="formrow" id="div_name">
            <input class="form-control" id="name" placeholder="{{__('Project Name')}}" name="name" type="text"
                   value="{{ isset($profileProject) ? $profileProject->name : '' }}">
            <span class="help-block name-error text-danger"></span>
        </div>
        
        @if(isset($profileProject))
            <div class="formrow">
                {{ ImgUploader::print_image("project_images/thumb/$profileProject->image") }}
            </div>
        @endif
        
        <div class="formrow" id="div_image">
            <div class="uploadphotobx dropzone needsclick dz-clickable" id="dropzone">
                <i class="fa fa-upload" aria-hidden="true"></i>
                <div class="dz-message" data-dz-message>
                    <span>{{ __('Drop files here or click to upload Project Image') }}</span>
                </div>
                <div class="fallback">
                    <input name="image" type="file"/>
                </div>
            </div>
            <span class="help-block image-error text-danger"></span>
        </div>
        
        <div class="formrow" id="div_url">
            <input class="form-control" id="url" placeholder="{{__('Project URL')}}" name="url" type="text"
                   value="{{ isset($profileProject) ? $profileProject->url : '' }}">
            <span class="help-block url-error text-danger"></span>
        </div>
        
        <div class="formrow" id="div_url">
            <input class="form-control" id="url" placeholder="{{__('Technologies Used')}}" name="tech" type="text"
                   value="{{ isset($profileProject) ? $profileProject->tech_stack : '' }}">
            <span class="help-block url-error text-danger"></span>
        </div>
        
        <div class="row">
            <div class="formrow col-md-6" id="div_date_start">
                <input class="form-control datepicker" autocomplete="off" id="date_start"
                       placeholder="{{__('Project Start Date')}}" name="date_start" type="text"
                       value="{{ isset($profileProject) ? $profileProject->date_start : '' }}">
                <span class="help-block date_start-error text-danger"></span>
            </div>
            
            <div class="formrow col-md-6" id="div_date_end">
                <input class="form-control datepicker" autocomplete="off" id="date_end"
                       placeholder="{{__('Project End Date')}}" name="date_end" type="text"
                       value="{{ isset($profileProject) ? $profileProject->date_end : '' }}">
                <span class="help-block date_end-error text-danger"></span>
            </div>
        </div>
        
        <div class="formrow" id="div_is_on_going">
            <label for="is_on_going" class="bold d-block mb-2">{{ __('Is Currently Ongoing?') }}</label>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_on_going" id="on_going"
                               value="1" {{ isset($profileProject) && $profileProject->is_on_going == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="on_going">{{ __('Yes') }}</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_on_going" id="not_on_going"
                               value="0" {{ isset($profileProject) && $profileProject->is_on_going == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="not_on_going">{{ __('No') }}</label>
                    </div>
                </div>
            </div>
            <span class="help-block is_on_going-error text-danger"></span>
        </div>
        
        <div class="formrow" id="div_description">
            <textarea name="description" class="form-control" id="description"
                      placeholder="{{__('Project description')}}">{{ isset($profileProject) ? $profileProject->description : '' }}</textarea>
            <span class="help-block description-error text-danger"></span>
        </div>
    
    </div>
</div>
