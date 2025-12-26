@extends('admin.layouts.admin_layout')
@section('content')


<div>
<h1>Resource Details</h1>
<p><strong>Name:</strong> {{ $resource->name }}</p>
<p><strong>Slug:</strong> {{ $resource->slug }}</p>
<p><strong>Number:</strong> {{ $resource->number }}</p>
<p><strong>Active:</strong> {{ $resource->is_active ? 'Yes' : 'No' }}</p>

<a href="{{ route('resources.index') }}">Back to Resources</a>
</div>

@endsection