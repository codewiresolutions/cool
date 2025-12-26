@extends('admin.layouts.admin_layout')
@section('content')
    <div class="page-content-wrapper">

        <div class="page-content">

            <br />
              @if (session('flash_notification'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: "{{ session('flash_notification')[0]['message'] }}",
                        timer: 3000,
                        showConfirmButton: false
                    });
                </script>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span
                                    class="caption-subject bold uppercase">Create Resource</span> </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="container mt-4">
                                <div class="card">

                                    <div class="card-body">
                                        <form action="{{ route('resources.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name:</label>
                                                <input type="text" id="name" name="name" class="form-control"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="slug" class="form-label">Slug:</label>
                                                <input type="text" id="slug" name="slug" class="form-control"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="number" class="form-label">Number:</label>
                                                <input type="number" id="number" name="number" class="form-control"
                                                    required>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                                    class="form-check-input">
                                                <label for="is_active" class="form-check-label">Is Active</label>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Create Resource</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        }
    </script>
@endsection
