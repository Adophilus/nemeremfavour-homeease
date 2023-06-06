<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Blogger;
use Illuminate\Validation\Rule;

class BloggerController extends Controller
{
    public function index()
    {
        $bloggers = Blogger::all();
        return view('bloggers.index', compact('bloggers'));
    }

    public function create()
    {
        return view('bloggers.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:bloggers',
            'password' => 'required|string|min:8',
            'school' => 'nullable|string|max:255',
            'verified' => 'boolean',
            'top_blogger' => 'boolean',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        $blogger = Blogger::create($validatedData);

        return redirect()->route('bloggers.show', $blogger->id)
            ->with('success', 'Blogger created successfully.');
    }

    public function edit($id)
    {
        $blogger = Blogger::findOrFail($id);
        return view('bloggers.edit', compact('blogger'));
    }

    public function update(Request $request, $id)
    {
        $blogger = Blogger::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('bloggers')->ignore($blogger->id)],
            'password' => 'nullable|string|min:8',
            'school' => 'nullable|string|max:255',
            'verified' => 'boolean',
            'top_blogger' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $blogger->update($validatedData);

        return redirect()->route('bloggers.show', $blogger->id)
            ->with('success', 'Blogger updated successfully.');
    }

    public function delete($id)
    {
        $blogger = Blogger::findOrFail($id);
        return view('bloggers.delete', compact('blogger'));
    }

    public function destroy($id)
    {
        $blogger = Blogger::findOrFail($id);
        $blogger->delete();

        return redirect()->route('bloggers.index')
            ->with('success', 'Blogger deleted successfully.');
    }
}