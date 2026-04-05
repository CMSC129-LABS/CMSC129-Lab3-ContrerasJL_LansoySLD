<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
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
        return view('orgs.archived', compact('orgs'));
    }

    public function create()
    {
        return view('orgs.create');
    }

    public function restore($id)
    {
        $org = Organization::findOrFail($id);
        $org->update(['is_archived' => false]);
        return redirect()->route('orgs.archived');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'email' => 'nullable|email',
        ]);

        Organization::create($request->all());
        return redirect()->route('orgs.index');
    }
}
