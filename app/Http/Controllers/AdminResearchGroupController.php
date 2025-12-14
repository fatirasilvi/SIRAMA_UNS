<?php

namespace App\Http\Controllers;

use App\Models\ResearchGroup;
use Illuminate\Http\Request;

class AdminResearchGroupController extends Controller
{
    // Tampilkan daftar research group
    public function index()
    {
        $groups = ResearchGroup::orderBy('nama_group')->get();
        return view('admin.research-group.index', compact('groups'));
    }

    // Form tambah
    public function create()
    {
        return view('admin.research-group.create');
    }

    // Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'nama_group' => 'required|string|max:255|unique:research_groups,nama_group',
            'deskripsi' => 'nullable|string',
            'ketua' => 'nullable|string|max:255',
        ]);

        ResearchGroup::create([
            'nama_group' => $request->nama_group,
            'deskripsi' => $request->deskripsi,
            'ketua' => $request->ketua,
            'is_active' => true,
        ]);

        return redirect()->route('admin.research-group.index')
            ->with('success', 'Research Group berhasil ditambahkan!');
    }

    // Form edit
    public function edit($id)
    {
        $group = ResearchGroup::findOrFail($id);
        return view('admin.research-group.edit', compact('group'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $group = ResearchGroup::findOrFail($id);

        $request->validate([
            'nama_group' => 'required|string|max:255|unique:research_groups,nama_group,' . $id,
            'deskripsi' => 'nullable|string',
            'ketua' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $group->update([
            'nama_group' => $request->nama_group,
            'deskripsi' => $request->deskripsi,
            'ketua' => $request->ketua,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.research-group.index')
            ->with('success', 'Research Group berhasil diperbarui!');
    }

    // Hapus data
    public function destroy($id)
    {
        $group = ResearchGroup::findOrFail($id);
        $group->delete();

        return redirect()->route('admin.research-group.index')
            ->with('success', 'Research Group berhasil dihapus!');
    }
}