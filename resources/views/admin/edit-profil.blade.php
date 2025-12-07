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

            <div class="row">

                <div class="col-md-8 mx-auto">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control"
                              value="{{ $admin->nama }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" name="username" class="form-control"
                              value="{{ $admin->username }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control"
                              value="{{ $admin->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control"
                              value="{{ $admin->jabatan }}">
                    </div>

                    <button type="submit" class="btn btn-primary px-4">
                        Simpan Perubahan
                    </button>

                </div>

            </div>
        </form>

    </div>
</div>

@endsection
