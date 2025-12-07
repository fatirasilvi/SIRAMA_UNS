<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penelitian;
use App\Models\Bidang;
use Illuminate\Support\Facades\Log;

class DosenPenelitianController extends Controller
{
    // ========== LIST PENELITIAN ==========
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();

        $penelitian = Penelitian::where('dosen_id', $dosen->id)
            ->orderBy('tahun', 'desc')
            ->get();
$bidangList = Bidang::where('is_active', true)
                        ->orderBy('nama_bidang')
                        ->get();

    return view('dosen.penelitian.index', compact('penelitian', 'bidangList'));
    }


    // ========== FORM TAMBAH PENELITIAN ==========
    public function create()
    {
        $dosenId = auth()->guard('dosen')->id();

        // Ambil semua bidang unik milik dosen
        $bidangList = Bidang::where('is_active', true)
                        ->orderBy('nama_bidang')
                        ->get();
    
    return view('dosen.penelitian.create', compact('bidangList'));
    }

    // ========== SIMPAN DATA BARU ==========
   public function store(Request $request)
{
    // Cek file SEBELUM validasi Laravel
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        
        \Log::info('File upload debug', [
            'has_file' => true,
            'is_valid' => $file->isValid(),
            'error_code' => $file->getError(),
            'error_message' => $file->getErrorMessage(),
            'original_name' => $file->getClientOriginalName(),
            'size_bytes' => $file->getSize(),
            'size_mb' => round($file->getSize() / 1024 / 1024, 2),
            'mime_type' => $file->getMimeType(),
            'extension' => $file->getClientOriginalExtension(),
        ]);
        
        // Jika file tidak valid, tampilkan error detail
        if (!$file->isValid()) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'File terlalu besar (melebihi upload_max_filesize di php.ini)',
                UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (melebihi MAX_FILE_SIZE di form)',
                UPLOAD_ERR_PARTIAL => 'File hanya terupload sebagian',
                UPLOAD_ERR_NO_FILE => 'Tidak ada file yang diupload',
                UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak ditemukan',
                UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk',
                UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh PHP extension',
            ];
            
            $errorCode = $file->getError();
            $errorMsg = $errorMessages[$errorCode] ?? 'Error tidak diketahui (code: ' . $errorCode . ')';
            
            \Log::error('File upload error', [
                'error_code' => $errorCode,
                'error_message' => $errorMsg,
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['file' => $errorMsg]);
        }
    }

    // Validasi Laravel
    $request->validate([
        'judul'   => 'required|string|max:255',
        'bidang_id' => 'required|exists:bidang,id',  // Validasi bidang_id
        'tahun'   => 'required|integer',
        'abstrak' => 'nullable|string',
        'file'    => 'nullable|file|mimes:pdf,doc,docx|max:5120',
    ]);

    $dosen = Auth::guard('dosen')->user();
    if (!$dosen) {
        return redirect()->back()->with('error', 'Session dosen tidak terbaca');
    }

    $filePath = null;
    
    // Upload file jika ada dan valid
    if ($request->hasFile('file') && $request->file('file')->isValid()) {
        try {
            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('penelitian', $fileName, 'public');
            
            \Log::info('File uploaded successfully', [
                'file_path' => $filePath,
                'full_path' => storage_path('app/public/' . $filePath),
            ]);
        } catch (\Exception $e) {
            \Log::error('File storage error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['file' => 'Gagal menyimpan file: ' . $e->getMessage()]);
        }
    }

    Penelitian::create([
        'dosen_id'  => $dosen->id,
        'judul'     => $request->judul,
        'bidang_id' => $request->bidang_id,
        'bidang'    => '', // Kosongkan kolom bidang lama
        'tahun'     => $request->tahun,
        'status'    => 'Menunggu Validasi',
        'abstrak'   => $request->abstrak,
        'file_path' => $filePath,
    ]);

    return redirect()->route('dosen.penelitian.index')
        ->with('success', 'Penelitian berhasil ditambahkan.');
}

    // ========== LIHAT DETAIL PENELITIAN ========== (TAMBAHKAN INI)
    public function show($id)
    {
        $data = Penelitian::findOrFail($id);

        // Pastikan dosen hanya bisa lihat penelitian miliknya sendiri
        if ($data->dosen_id != Auth::guard('dosen')->id()) {
            abort(403, 'Anda tidak memiliki akses ke penelitian ini.');
        }

        return view('dosen.penelitian.show', compact('data'));
    }


    // ========== FORM EDIT PENELITIAN ========== (TAMBAHKAN INI JUGA)
    public function edit($id)
    {
        $data = Penelitian::findOrFail($id);

    if ($data->dosen_id != Auth::guard('dosen')->id()) {
        abort(403);
    }

    $bidangList = Bidang::where('is_active', true)
                        ->orderBy('nama_bidang')
                        ->get();

    return view('dosen.penelitian.edit', compact('data', 'bidangList'));
    }


    // ========== UPDATE DATA ==========
    public function update(Request $request, $id)
    {
        $data = Penelitian::findOrFail($id);

    if ($data->dosen_id != Auth::guard('dosen')->id()) {
        abort(403, 'Anda tidak memiliki akses untuk mengedit penelitian ini.');
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
        'judul'     => 'required|string|max:255',
        'bidang_id' => 'required|exists:bidang,id',
        'tahun'     => 'required|integer',
        'abstrak'   => 'nullable|string',
        'file'      => 'nullable|file|mimes:pdf,doc,docx|max:5120',
    ]);

    $filePath = $data->file_path;
    
    if ($request->hasFile('file') && $request->file('file')->isValid()) {
        try {
            if ($data->file_path && \Storage::disk('public')->exists($data->file_path)) {
                \Storage::disk('public')->delete($data->file_path);
            }
            
            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('penelitian', $fileName, 'public');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['file' => 'Gagal upload file baru: ' . $e->getMessage()]);
        }
    }

    $data->update([
        'judul'     => $request->judul,
        'bidang_id' => $request->bidang_id,
        'tahun'     => $request->tahun,
        'abstrak'   => $request->abstrak,
        'file_path' => $filePath,
    ]);

    return redirect()->route('dosen.penelitian.show', $data->id)
        ->with('success', 'Data penelitian berhasil diperbarui!');
}


    // ========== HAPUS DATA ==========
    public function destroy($id)
    {
        $data = Penelitian::findOrFail($id);

        if ($data->dosen_id != Auth::guard('dosen')->id()) {
            abort(403);
        }

        // Hapus file jika ada
        if ($data->file_path && \Storage::disk('public')->exists($data->file_path)) {
            \Storage::disk('public')->delete($data->file_path);
        }

        $data->delete();

        return redirect()->route('dosen.penelitian.index')
            ->with('success', 'Data penelitian berhasil dihapus.');
    }
}