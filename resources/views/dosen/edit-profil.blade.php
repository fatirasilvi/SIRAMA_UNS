@extends('layouts.main')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold">
        Edit Profil Dosen
    </div>

    <div class="card-body">

        {{-- ALERT BERHASIL --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('dosen.update.profil') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

                {{-- FOTO PROFIL --}}
                <div class="col-md-4 text-center">
                    <img 
                        src="{{ $dosen->foto 
                            ? asset('storage/dosen/' . $dosen->foto) 
                            : asset('img/user.png') }}"
                        class="rounded-circle mb-3"
                        id="previewFoto"
                        style="width:130px; height:130px; object-fit:cover;"
                    >

                    <input type="file" name="foto" class="form-control mt-2" onchange="previewImage(event)">
                    <small class="text-muted">Format: JPG, PNG (Maks 2MB)</small>
                </div>

                {{-- FORM --}}
                <div class="col-md-8">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" 
                               value="{{ $dosen->nama }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">NIP</label>
                        <input type="text" name="nip" class="form-control" 
                               value="{{ $dosen->nip }}" required>
                    </div>

                    <div class="mb-3">
    <label class="form-label fw-bold">Program Studi</label>
    <select name="prodi_id" class="form-select">
        <option value="">-- Pilih Prodi --</option>
        @foreach($prodiList as $p)
            <option value="{{ $p->id }}" {{ $dosen->prodi_id == $p->id ? 'selected' : '' }}>
                {{ $p->nama }}
            </option>
        @endforeach
    </select>
</div>


                    <div class="mb-3">
                        <label class="form-label fw-bold">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" 
                               value="{{ $dosen->jabatan }}">
                    </div>

                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>

                </div>

            </div>
        </form>

    </div>
</div>

<script>
    function previewImage(event) {
        document.getElementById('previewFoto').src = URL.createObjectURL(event.target.files[0]);
    }
</script>

@endsection
