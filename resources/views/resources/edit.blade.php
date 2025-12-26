@extends('admin.layouts.admin_layout')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">

        <br>
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
            <div class="col-md-10 mx-auto">

                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="icon-settings font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase">Edit Resource</span>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div class="card shadow-sm">
                            
                            <div class="card-body">

                                <form action="{{ route('resources.update', $resource->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    {{-- Name --}}
                                    <div class="form-group mb-3">
                                        <label class="fw-bold">Name</label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror"
                                               name="name"
                                               value="{{ old('name', $resource->name) }}"
                                               placeholder="Enter resource name"
                                               required>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Slug --}}
                                    <div class="form-group mb-3">
                                        <label class="fw-bold">Slug</label>
                                        <input type="text" 
                                               class="form-control @error('slug') is-invalid @enderror"
                                               name="slug"
                                               value="{{ old('slug', $resource->slug) }}"
                                               placeholder="Enter slug"
                                               required>
                                        @error('slug')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Number --}}
                                    <div class="form-group mb-3">
                                        <label class="fw-bold">Number</label>
                                        <input type="number" 
                                               class="form-control @error('number') is-invalid @enderror"
                                               name="number"
                                               value="{{ old('number', $resource->number) }}"
                                               placeholder="Enter number"
                                               required>
                                        @error('number')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Active --}}
                                    <div class="form-check mb-3">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               id="is_active"
                                               name="is_active"
                                               value="1"
                                               {{ $resource->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_active">
                                            Active Resource
                                        </label>
                                    </div>

                                    {{-- Buttons --}}
                                    <div class="d-flex justify-content-between mt-4">

                                        <a href="{{ route('resources.index') }}" class="btn btn-light border">
                                            Cancel
                                        </a>

                                        <button type="submit" class="btn btn-primary">
                                            Update Resource
                                        </button>
                                    </div>

                                </form>

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
