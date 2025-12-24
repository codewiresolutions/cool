<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form class="form" id="add_edit_profile_project" method="POST"
              action="{{ route('store.front.profile.project', [$user->id]) }}">
            {{ csrf_field() }}

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="col-md-12 text-center">
                    <h2 class="modal-title" style="font-weight: bold; font-size: 28px; margin: 15px 0; color: #2c3e50;">
                        {{ __('Your Project Details') }}
                    </h2>
                </div>
            </div>

            @include('user.forms.project.project_form')

            <div class="modal-footer">
                <button type="button" class="btn btn-large btn-primary" onClick="submitProfileProjectForm();">
                    {{ __('Add Project') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                </button>
            </div>
        </form>
    </div>
</div>
