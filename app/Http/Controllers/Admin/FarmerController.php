<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function index()
    {
        $farmers = Farmer::orderBy('name')->paginate(10);

        return view('admin.farmers.index', compact('farmers'));
    }

    public function create()
    {
        return view('admin.farmers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        Farmer::create($data);

        return redirect()->route('admin.farmers.index')->with('status', 'Farmer created.');
    }

    public function edit(Farmer $farmer)
    {
        return view('admin.farmers.edit', compact('farmer'));
    }

    public function update(Request $request, Farmer $farmer): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $farmer->update($data);

        return redirect()->route('admin.farmers.index')->with('status', 'Farmer updated.');
    }

    public function destroy(Farmer $farmer): RedirectResponse
    {
        $farmer->delete();

        return redirect()->route('admin.farmers.index')->with('status', 'Farmer deleted.');
    }
}
