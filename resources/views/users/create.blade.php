@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        Tambah Pengguna
    </div>

    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="name"
                    class="form-control"
                    value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email"
                    class="form-control"
                    value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Role Pengguna</label>

                <select name="role" class="form-select" required>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                    <option value="owner">Owner</option>
                </select>
            </div>

            <button class="btn btn-primary">Simpan</button>

            <a href="{{ route('users.index') }}"
               class="btn btn-secondary">Kembali</a>

        </form>

    </div>
</div>

@endsection