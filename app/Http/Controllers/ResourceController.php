<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = Resource::all();
        return view('resources.index', compact('resources'));
    }

    public function create()
    {
        return view('resources.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:resources',
            'number' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        Resource::create($request->all());
        return redirect()->route('resources.index')->with('flash_notification', [
            ['level' => 'success', 'message' => 'Resource created successfully.']
        ]);
    }

    public function edit(Resource $resource)
    {
        return view('resources.edit', compact('resource'));
    }

    public function update(Request $request, Resource $resource)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:resources,slug,' . $resource->id,
            'number' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $resource->update($request->all());
        return redirect()->route('resources.index')->with('flash_notification', [
            ['level' => 'success', 'message' => 'Resource updated successfully.']
        ]);
    }

    public function destroy(Resource $resource)
    {
        $resource->delete();
        return redirect()->route('resources.index')->with('flash_notification', [
            ['level' => 'success', 'message' => 'Resource deleted successfully.']
        ]);
    }
}
