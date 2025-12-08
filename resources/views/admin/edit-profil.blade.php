@extends('layouts.main')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold">
        Edit Profil Admin
    </div>

    <div class="card-body">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.update.profil') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold">Nama</label>
                <input type="text" 
                       name="nama" 
                       class="form-control" 
                       value="{{ auth()->guard('admin')->user()->nama }}" 
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">NIP</label>
                <input type="text" 
                       name="nip" 
                       class="form-control" 
                       value="{{ auth()->guard('admin')->user()->nip }}" 
                       required>
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan Perubahan
            </button>
        </form>

    </div>
</div>

@endsection
