
@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')

<div class="container-fluid px-0">

    {{-- JUDUL DAN TOMBOL TAMBAH --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Manajemen Pengguna
            </h3>

            <p class="text-muted mb-0">
                Kelola data pengguna sistem parkir.
            </p>
        </div>

        <a href="{{ route('users.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Tambah Pengguna
        </a>

    </div>

    {{-- TABEL PENGGUNA --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th style="min-width: 60px;">No</th>
                            <th style="min-width: 150px;">Nama</th>
                            <th style="min-width: 200px;">Email</th>
                            <th style="min-width: 100px;">Role</th>
                            <th style="min-width: 150px;">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                            <tr>

                                <td>
                                    {{ $users->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ $user->name }}
                                </td>

                                <td>
                                    {{ $user->email }}
                                </td>

                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-primary">
                                            Admin
                                        </span>
                                    @elseif($user->role === 'petugas')
                                        <span class="badge bg-success">
                                            Petugas
                                        </span>
                                    @elseif($user->role === 'owner')
                                        <span class="badge bg-warning text-dark">
                                            Owner
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    @endif
                                </td>

                                <td>

                                    {{-- TOMBOL EDIT --}}
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                        Edit
                                    </a>

                                    {{-- TOMBOL HAPUS --}}
                                    <form action="{{ route('users.destroy', $user->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="bi bi-people fs-2 text-muted"></i>

                                    <p class="text-muted mb-0 mt-2">
                                        Belum ada data pengguna.
                                    </p>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="mt-3">
                {{ $users->links() }}
            </div>

        </div>

    </div>

</div>

@endsection
