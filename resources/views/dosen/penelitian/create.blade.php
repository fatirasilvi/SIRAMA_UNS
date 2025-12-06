@extends('layouts.main')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header fw-bold bg-white">
        Tambah Penelitian
    </div>

    <div class="card-body">

        <form action="{{ route('dosen.penelitian.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Judul Penelitian</label>
                <input type="text" name="judul" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Bidang</label>
                <input type="text" name="bidang" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tahun</label>
                <input type="number" name="tahun" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="Draft">Draft</option>
                    <option value="Pengajuan">Pengajuan</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Abstrak</label>
                <textarea name="abstrak" rows="6" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload File Penelitian</label>
                <input type="file" name="file" class="form-control">
                <small class="text-muted">Format: PDF/DOC/DOCX, max 5MB</small>
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan
            </button>

        </form>

    </div>
</div>

@endsection
