<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\FuncCall;

class OrgController extends Controller
{
    public function index(Request $request)
    {
        $query = Organization::where('is_archived', false);

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->input('q') . '%');
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

    public function archived()
    {
        $orgs = Organization::where('is_archived', true)->get();
        $selected = $orgs->first();
        return view('orgs.archived', compact('orgs', 'selected'));
    }

    public function archivedShow($id)
    {
        $orgs = Organization::where('is_archived', true)->get();
        $selected = Organization::findOrFail($id);
        return view('orgs.archived', compact('orgs', 'selected'));
    }

    public function restore($id)
    {
        $org = Organization::findOrFail($id);
        $org->update(['is_archived' => false]);
        return redirect()->route('orgs.archived');
    }

    public function show($id)
    {
        $orgs = Organization::where('is_archived', false)->get();
        $selected = Organization::findOrFail($id);
        return view('orgs.index', compact('orgs', 'selected'));
    }

    public function archive($id)
    {
        Organization::findOrFail($id)->update(['is_archived' => true]);
        // return redirect()->route('orgs.index');
        return redirect()->route('orgs.index')->with('success', 'org moved to archives successfully.');
    }

    public function destroy($id)
    {
        $org = Organization::findOrFail($id);

        // delete images from storage
        if ($org->logo) Storage::delete('public/' . $org->logo);
        if ($org->cover) Storage::delete('public/' . $org->cover);

        $org->delete();
        return redirect()->route('orgs.archived');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'type'    => 'required|string',
            'email'   => 'nullable|email',
            'logo'    => 'nullable|image|max:2048',
            'cover'   => 'nullable|image|max:2048',
        ]);

        $org = Organization::findOrFail($id);
        $data = $request->except(['logo', 'cover']);

        if ($request->hasFile('logo')) {
            // delete old logo
            if ($org->logo) Storage::delete('public/' . $org->logo);
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('cover')) {
            // delete old cover
            if ($org->cover) Storage::delete('public/' . $org->cover);
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $org->update($data);
        return redirect()->route('orgs.index');
    }

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

        Organization::create($data);
        // return redirect()->route('orgs.index');
        return redirect()->route('orgs.index')->with('success', 'org added successfully.');
    }
}
