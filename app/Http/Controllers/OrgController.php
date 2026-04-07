<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrgController extends Controller
{
    public function index(Request $request)
    {
        $query = Organization::where('is_archived', false);

        if ($request->filled('q')) {
            $query->where('name', 'ilike', '%' . $request->input('q') . '%');
        }

        if ($request->filter_status && $request->filter_status !== 'all') {
            $query->where('status', $request->filter_status);
        }

        if ($request->filled('filter_type')) {
            $query->whereIn('type', $request->filter_type);
        }

        $orgs = $query->get();
        $selected = $orgs->first();

        return view('orgs.index', compact('orgs', 'selected'));
    }

    // archived orgs list
    public function archived()
    {
        $orgs = Organization::where('is_archived', true)->get();
        $selected = $orgs->first();
        return view('orgs.archived', compact('orgs', 'selected'));
    }

    // show archived org details
    public function archivedShow($id)
    {
        $orgs = Organization::where('is_archived', true)->get();
        $selected = Organization::findOrFail($id);
        return view('orgs.archived', compact('orgs', 'selected'));
    }

    // restore org
    public function restore($id)
    {
        $org = Organization::findOrFail($id);
        $org->update([
            'is_archived' => false,
            'archived_at' => null,
        ]);
        return redirect()->route('orgs.archived')->with('success', 'org restored sucessfully.');
    }

    // search orgs for select input
    public function search(Request $request)
    {
        $q = $request->input('q', '');
        $orgs = Organization::where('is_archived', false)
            ->where('name', 'ilike', '%' . $q . '%')
            ->limit(5)
            ->get(['id', 'name', 'type', 'logo']);

        return response()->json($orgs);
    }
    
    // show org details
    public function show(Request $request, $id)
    {
        $query = Organization::where('is_archived', false);

        if ($request->filled('q')) {
            $query->where('name', 'ilike', '%' . $request->input('q') . '%');
        }

        if ($request->filter_status && $request->filter_status !== 'all') {
            $query->where('status', $request->filter_status);
        }

        if ($request->filled('filter_type')) {
            $query->whereIn('type', $request->filter_type);
        }

        $orgs = $query->get();
        $selected = $orgs->firstWhere('id', $id) ?? $orgs->first();

        return view('orgs.index', compact('orgs', 'selected'));
    }

    // archive org
    public function archive($id)
    {
        Organization::findOrFail($id)->update([
            'is_archived' => true,
            'archived_at' => now(),
        ]);
        return redirect()->route('orgs.index')->with('success', 'org moved to archives.');
    }

    // delete org permanently
    public function destroy($id)
    {
        $org = Organization::findOrFail($id);

        // delete images from storage
        if ($org->logo) {
            Storage::disk('public')->delete($org->logo);
        }

        if ($org->cover) {
            Storage::disk('public')->delete($org->cover);
        }

        $org->delete();
        return redirect()->route('orgs.archived')->with('success', 'org deleted permanently.');
    }

    // update org
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'type'    => 'required|string',
            'email'   => 'nullable|email',
            'logo'    => 'nullable|image|max:5120',
            'cover'   => 'nullable|image|max:5120',
        ]);

        $org = Organization::findOrFail($id);
        $data = $request->except(['logo', 'cover']);

        if ($request->hasFile('logo')) {
            if ($org->logo) Storage::disk('public')->delete($org->logo);
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('cover')) {
            if ($org->cover) Storage::disk('public')->delete($org->cover);
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $org->update($data);
        return redirect()->route('orgs.show', $org->id)->with('success', 'org updated successfully.');
    }

    // add new org
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'type'    => 'required|string',
            'email'   => 'nullable|email',
            'logo'    => 'nullable|image|max:2048',
            'cover'   => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['logo', 'cover']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $org = Organization::create($data);
        
        // return redirect()->route('orgs.index');
        return redirect()->route('orgs.show', $org)->with('success', 'org created successfully.');
    }
}
