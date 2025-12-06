@extends('layouts.main')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Kelola Penelitian Anda</h4>

        <a href="{{ route('dosen.penelitian.create') }}" class="btn btn-success px-4">
            + Tambah Penelitian
        </a>
    </div>

    {{-- FILTER ROW --}}
    <div class="card mb-3 shadow-sm border-0">
        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-3">
                    <label class="fw-semibold mb-1">Tahun</label>
                    <select class="form-select">
                        <option>Semua Tahun</option>
                        <option>2025</option>
                        <option>2024</option>
                        <option>2023</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="fw-semibold mb-1">Bidang</label>
                    <select class="form-select">
                        <option>Semua Bidang</option>
                        <option>Artificial Intelligent</option>
                        <option>Big Data</option>
                        <option>IoT</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="fw-semibold mb-1">Status</label>
                    <select class="form-select">
                        <option>Semua Status</option>
                        <option>Menunggu Validasi</option>
                        <option>Disetujui</option>
                        <option>Ditolak</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="fw-semibold mb-1">Pencarian</label>
                    <input type="text" class="form-control" placeholder="Cari judul...">
                </div>

            </div>

        </div>
    </div>

    {{-- TABEL --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <table class="table table-hover align-middle">

                <thead>
                    <tr class="text-secondary">
                        <th>Judul</th>
                        <th>Bidang</th>
                        <th>Tahun</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
    @forelse ($penelitian as $p)
        <tr>
            <td style="max-width: 350px;">
                <a href="#" class="fw-semibold text-decoration-none">
                    {{ $p->judul }}
                </a>
            </td>

            <td>{{ $p->bidang }}</td>
            <td>{{ $p->tahun }}</td>

            <td>
                @if ($p->status == 'Menunggu Validasi')
                    <span class="badge bg-warning text-dark px-3 py-2">Menunggu Validasi</span>
                @elseif ($p->status == 'Disetujui')
                    <span class="badge bg-success px-3 py-2">Disetujui</span>
                @else
                    <span class="badge bg-danger px-3 py-2">Ditolak</span>
                @endif
            </td>

            <td class="text-center">
                <a href="#" class="text-primary me-2"><i class="bi bi-eye"></i></a>
                <a href="{{ route('dosen.penelitian.edit', $p->id) }}" class="text-success me-2">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('dosen.penelitian.delete', $p->id) }}"
                      method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-link text-danger p-0">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center text-muted py-4">
                Belum ada penelitian yang diajukan.
            </td>
        </tr>
    @endforelse
</tbody>


            </table>

        </div>
    </div>

</div>

@endsection
