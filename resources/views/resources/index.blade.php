
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
                                    class="caption-subject bold uppercase">Resource</span> </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="container mt-4">
                                <div class="card">

                                    <div class="card-body">
                                        <div class="container">

                                            <a href="{{ route('resources.create') }}" class="btn btn-primary">Create New
                                                Resource</a>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Slug</th>
                                                        <th>Number</th>
                                                        <th>Active</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($resources as $resource)
                                                        <tr>
                                                            <td>{{ $resource->name }}</td>
                                                            <td>{{ $resource->slug }}</td>
                                                            <td>{{ $resource->number }}</td>
                                                            <td>{{ $resource->is_active ? 'Yes' : 'No' }}</td>
                                                            <td>
                                                                <a href="{{ route('resources.edit', $resource->id) }}"
                                                                    class="btn btn-warning">Edit</a>
                                                                <form
                                                                    action="{{ route('resources.destroy', $resource->id) }}"
                                                                    method="POST" style="display:inline;"
                                                                    onsubmit="return confirmDelete(event)">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Delete</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
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
