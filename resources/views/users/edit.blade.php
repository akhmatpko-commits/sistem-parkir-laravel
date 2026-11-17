@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        Edit Pengguna
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

        <form method="POST"
            action="{{ route('users.update', $user->id) }}">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name"
                    class="form-control"
                    value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email"
                    class="form-control"
                    value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label>Role</label>

                <select name="role" class="form-select">
                    @foreach(['admin', 'petugas', 'owner'] as $role)
                        <option value="{{ $role }}"
                            @selected(old('role', $user->role) === $role)>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Password Baru (kosongkan jika tidak diubah)</label>
                <input type="password" name="password"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation"
                    class="form-control">
            </div>

            <button class="btn btn-primary">Update Pengguna</button>

            <a href="{{ route('users.index') }}"
               class="btn btn-secondary">Kembali</a>

        </form>

    </div>
</div>

@endsection