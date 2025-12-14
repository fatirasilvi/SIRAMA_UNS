<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengabdian;
use App\Models\Bidang;
use App\Models\ResearchGroup;
use Illuminate\Support\Facades\Storage;

class DosenPengabdianController extends Controller
{
    // INDEX
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();

        $pengabdian = Pengabdian::with(['bidangRelation', 'researchGroup'])
                                ->where('dosen_id', $dosen->id)
                                ->orderBy('tahun', 'desc')
                                ->get();
        
        $bidangList = Bidang::where('is_active', true)
                            ->orderBy('nama_bidang')
                            ->get();

        return view('dosen.pengabdian.index', compact('pengabdian', 'bidangList'));
    }

    // CREATE
    public function create()
    {
        $bidangList = Bidang::where('is_active', true)
                            ->orderBy('nama_bidang')
                            ->get();
        
        $researchGroups = ResearchGroup::where('is_active', true)
                                       ->orderBy('nama_group')
                                       ->get();

        return view('dosen.pengabdian.create', compact('bidangList', 'researchGroups'));
    }

    // STORE
    public function store(Request $request)
    {
        $dosen = Auth::guard('dosen')->user();
        
        if (!$dosen) {
            return redirect()->back()->with('error', 'Session dosen tidak terbaca');
        }

        // Cek file sebelum validasi
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            if (!$file->isValid()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['file' => 'File gagal diupload: ' . $file->getErrorMessage()]);
            }
        }

        $request->validate([
            'judul'             => 'required|string|max:255',
            'bidang_id'         => 'required|exists:bidang,id',
            'research_group_id' => 'nullable|exists:research_groups,id',
            'tahun'             => 'required|integer',
            'abstrak'           => 'nullable|string',
            'file'              => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $filePath = null;
        
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            try {
                $file = $request->file('file');
                $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
                $filePath = $file->storeAs('pengabdian', $fileName, 'public');
                
                \Log::info('File uploaded successfully', ['file_path' => $filePath]);
            } catch (\Exception $e) {
                \Log::error('File storage error', ['error' => $e->getMessage()]);
                
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['file' => 'Gagal menyimpan file: ' . $e->getMessage()]);
            }
        }

        Pengabdian::create([
            'dosen_id'          => $dosen->id,
            'judul'             => $request->judul,
            'bidang_id'         => $request->bidang_id,
            'research_group_id' => $request->research_group_id,
            'tahun'             => $request->tahun,
            'status'            => 'Menunggu Validasi',
            'abstrak'           => $request->abstrak,
            'file_path'         => $filePath,
        ]);

        return redirect()->route('dosen.pengabdian.index')
            ->with('success', 'Pengabdian berhasil ditambahkan!');
    }

    // SHOW
    public function show($id)
    {
        $data = Pengabdian::with(['bidangRelation', 'researchGroup'])
                          ->findOrFail($id);

        if ($data->dosen_id != Auth::guard('dosen')->id()) {
            abort(403, 'Anda tidak memiliki akses ke pengabdian ini.');
        }

        return view('dosen.pengabdian.show', compact('data'));
    }

    // EDIT
    public function edit($id)
    {
        $data = Pengabdian::findOrFail($id);

        if ($data->dosen_id != Auth::guard('dosen')->id()) {
            abort(403);
        }

        $bidangList = Bidang::where('is_active', true)
                            ->orderBy('nama_bidang')
                            ->get();
        
        $researchGroups = ResearchGroup::where('is_active', true)
                                       ->orderBy('nama_group')
                                       ->get();

        return view('dosen.pengabdian.edit', compact('data', 'bidangList', 'researchGroups'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $data = Pengabdian::findOrFail($id);

        if ($data->dosen_id != Auth::guard('dosen')->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit pengabdian ini.');
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            if (!$file->isValid()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['file' => 'File gagal diupload: ' . $file->getErrorMessage()]);
            }
        }

        $request->validate([
            'judul'             => 'required|string|max:255',
            'bidang_id'         => 'required|exists:bidang,id',
            'research_group_id' => 'nullable|exists:research_groups,id',
            'tahun'             => 'required|integer',
            'abstrak'           => 'nullable|string',
            'file'              => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $filePath = $data->file_path;
        
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            try {
                if ($data->file_path && Storage::disk('public')->exists($data->file_path)) {
                    Storage::disk('public')->delete($data->file_path);
                }
                
                $file = $request->file('file');
                $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
                $filePath = $file->storeAs('pengabdian', $fileName, 'public');
                
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['file' => 'Gagal upload file baru: ' . $e->getMessage()]);
            }
        }

        $data->update([
            'judul'             => $request->judul,
            'bidang_id'         => $request->bidang_id,
            'research_group_id' => $request->research_group_id,
            'tahun'             => $request->tahun,
            'abstrak'           => $request->abstrak,
            'file_path'         => $filePath,
        ]);

        return redirect()->route('dosen.pengabdian.show', $data->id)
            ->with('success', 'Data pengabdian berhasil diperbarui!');
    }

    // DESTROY
    public function destroy($id)
    {
        $data = Pengabdian::findOrFail($id);

        if ($data->dosen_id != Auth::guard('dosen')->id()) {
            abort(403);
        }

        if ($data->file_path && Storage::disk('public')->exists($data->file_path)) {
            Storage::disk('public')->delete($data->file_path);
        }

        $data->delete();

        return redirect()->route('dosen.pengabdian.index')
            ->with('success', 'Data pengabdian berhasil dihapus!');
    }
}