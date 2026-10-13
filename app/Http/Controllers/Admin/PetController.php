<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::latest()->get();
        return view('admin.pets.index', compact('pets'));
    }

    public function create()
    {
        return view('admin.pets.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('pets', 'public');
        }

        Pet::create($data);

        return redirect()->route('admin.pets.index')->with('success', 'Hewan berhasil ditambahkan.');
    }

    public function edit(Pet $pet)
    {
        return view('admin.pets.edit', compact('pet'));
    }

    public function update(Request $request, Pet $pet)
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            if ($pet->photo) {
                Storage::disk('public')->delete($pet->photo);
            }
            $data['photo'] = $request->file('photo')->store('pets', 'public');
        }

        $pet->update($data);

        return redirect()->route('admin.pets.index')->with('success', 'Data hewan berhasil diperbarui.');
    }

    public function destroy(Pet $pet)
    {
        if ($pet->photo) {
            Storage::disk('public')->delete($pet->photo);
        }
        $pet->delete();

        return redirect()->route('admin.pets.index')->with('success', 'Hewan berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'species'     => ['required', 'string', 'max:100'],
            'breed'       => ['nullable', 'string', 'max:100'],
            'age'         => ['required', 'string', 'max:50'],
            'gender'      => ['required', 'in:Jantan,Betina'],
            'status'      => ['required', 'in:tersedia,diadopsi'],
            'description' => ['nullable', 'string'],
            'photo'       => ['nullable', 'image', 'max:2048'],
        ]);
    }
}