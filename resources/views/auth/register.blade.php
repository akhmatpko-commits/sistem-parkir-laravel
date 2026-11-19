
@extends('layouts.app')

@section('title', request()->routeIs('register') ? 'Register Owner' : 'Register Petugas')

@section('page-title', request()->routeIs('register') ? 'Register Owner' : 'Register Petugas')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <h4 class="fw-bold mb-2">
                    {{ request()->routeIs('register') ? 'Daftar Akun Owner' : 'Tambah Akun Petugas' }}
                </h4>

                <p class="text-muted mb-4">
                    {{ request()->routeIs('register')
                        ? 'Daftarkan akun Owner baru.'
                        : 'Daftarkan akun petugas baru.' }}
                </p>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ request()->routeIs('register') ? route('register.submit') : route('register.store') }}"
                      method="POST">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name') }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email') }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-person-plus me-1"></i>

                        {{ request()->routeIs('register') ? 'Daftar sebagai Owner' : 'Daftarkan Petugas' }}
                    </button>

                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100 mt-2">
                            Kembali ke Login
                        </a>
                    @endguest

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
