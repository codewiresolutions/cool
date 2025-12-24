<hr>
<div class="row">
    <div class="col-md-12">
        <div class="formrow">
            <label for="cvs" class="d-block" id="cvs" style="font-weight: bold; font-size: 18px;">
                {{ __('Your Curriculum Vitae') }}
            </label>
            <div id="cvs_div" class="mt-2"></div>
            <div class="text-right mt-3">
                <a href="javascript:" class="btn btn-success" onclick="showProfileCvModal();">
                    {{ __('Add CV') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="add_cv_modal" role="dialog"></div>

@push('css')
    
    <style type="text/css">
        .datepicker > div {
            display: block;
        }
    </style>

@endpush

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            showCvs();
        });

        /**************************************************/

        function showProfileCvModal() {
            $("#add_cv_modal").modal();
            loadProfileCvForm();
        }

        function loadProfileCvForm() {
            $.ajax({
                type: "POST",
                url: "{{ route('get.front.profile.cv.form', $user->id) }}",
                data: {"_token": "{{ csrf_token() }}"},
                datatype: 'json',
                success: function (json) {
                    $("#add_cv_modal").html(json.html);
                }
            });
        }

        function submitProfileCvForm() {
            var form = $('#add_edit_profile_cv');
            var formData = new FormData();

            formData.append("id", $('#id').val());
            formData.append("_token", $('input[name=_token]').val());
            formData.append("title", $('#title').val());
            formData.append("is_default", $('input[name=is_default]:checked').val());
            if (document.getElementById("cv_file").value != "") {
                formData.append("cv_file", $('#cv_file')[0].files[0]);
            }

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (json) {
                    $("#add_cv_modal").html(json.html);
                    showCvs();
                },
                error: function (json) {
                    if (json.status === 422) {
                        var resJSON = json.responseJSON;
                        $('.help-block').html('');
                        $.each(resJSON.errors, function (key, value) {
                            $('.' + key + '-error').html('<strong>' + value + '</strong>');
                            $('#div_' + key).addClass('has-error');
                        });
                    }
                }
            });
        }

        /*****************************************/

        function showProfileCvEditModal(cv_id) {
            $("#add_cv_modal").modal();
            loadProfileCvEditForm(cv_id);
        }

        function loadProfileCvEditForm(cv_id) {
            $.ajax({
                type: "POST",
                url: "{{ route('get.front.profile.cv.edit.form', $user->id) }}",
                data: {"cv_id": cv_id, "_token": "{{ csrf_token() }}"},
                datatype: 'json',
                success: function (json) {
                    $("#add_cv_modal").html(json.html);
                }
            });
        }

        /*****************************************/

        function showCvs() {
            $.post("{{ route('show.front.profile.cvs', $user->id) }}", {
                user_id: {{$user->id}},
                _method: 'POST',
                _token: '{{ csrf_token() }}'
            })
                .done(function (response) {
                    $('#cvs_div').html(response);
                });
        }

        function delete_profile_cv(id) {
            var msg = "{{__('Are you sure! you want to delete?')}}";
            if (confirm(msg)) {
                $.post("{{ route('delete.front.profile.cv') }}", {
                    id: id,
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {
                        if (response == 'ok') {
                            $('#cv_' + id).remove();
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }
    </script>

@endpush

