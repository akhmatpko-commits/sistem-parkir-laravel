
@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <h5 class="fw-bold mb-3">
                <i class="bi bi-clock-history"></i>
                Riwayat Aktivitas Pengguna
            </h5>

            <form method="GET"
                  action="{{ route('admin.activity-logs.index') }}">

                <div class="row g-3">

                    <div class="col-md-3">
                        <label class="form-label">
                            Nama Pengguna
                        </label>

                        <input type="text"
                               name="user_name"
                               class="form-control"
                               value="{{ request('user_name') }}"
                               placeholder="Cari pengguna">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">
                            Role
                        </label>

                        <select name="user_role"
                                class="form-select">

                            <option value="">Semua Role</option>

                            <option value="admin"
                                @selected(request('user_role') == 'admin')>
                                Admin
                            </option>

                            <option value="petugas"
                                @selected(request('user_role') == 'petugas')>
                                Petugas
                            </option>

                            <option value="owner"
                                @selected(request('user_role') == 'owner')>
                                Owner
                            </option>

                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">
                            Aktivitas
                        </label>

                        <input type="text"
                               name="activity"
                               class="form-control"
                               value="{{ request('activity') }}"
                               placeholder="Aktivitas">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">
                            Dari Tanggal
                        </label>

                        <input type="date"
                               name="tanggal_mulai"
                               class="form-control"
                               value="{{ request('tanggal_mulai') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">
                            Sampai Tanggal
                        </label>

                        <input type="date"
                               name="tanggal_akhir"
                               class="form-control"
                               value="{{ request('tanggal_akhir') }}">
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-primary w-100"
                                type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                </div>

                <div class="mt-3">
                    <a href="{{ route('admin.activity-logs.index') }}"
                       class="btn btn-secondary btn-sm">
                        Reset Filter
                    </a>
                </div>

            </form>

        </div>
    </div>


    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">

                <h5 class="fw-bold">
                    Daftar Log Aktivitas
                </h5>

                <span class="badge bg-primary">
                    {{ $logs->total() }} Aktivitas
                </span>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Pengguna</th>
                            <th>Role</th>
                            <th>Aktivitas</th>
                            <th>Modul</th>
                            <th>Keterangan</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($logs as $index => $log)

                            <tr>

                                <td>
                                    {{ $logs->firstItem() + $index }}
                                </td>

                                <td>
                                    {{ $log->created_at?->format('d-m-Y H:i:s') ?? '-' }}
                                </td>

                                <td>
                                    {{ $log->user_name ?? 'Pengguna tidak tersedia' }}
                                </td>

                                <td>
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($log->user_role ?? '-') }}
                                    </span>
                                </td>

                                <td>
                                    {{ $log->activity }}
                                </td>

                                <td>
                                    {{ $log->module ?? '-' }}
                                </td>

                                <td>
                                    {{ $log->description ?? '-' }}
                                </td>

                                <td>
                                    {{ $log->ip_address ?? '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8"
                                    class="text-center text-muted py-4">

                                    <i class="bi bi-inbox fs-3"></i>

                                    <p class="mb-0">
                                        Belum ada aktivitas tercatat.
                                    </p>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $logs->links() }}
            </div>

        </div>

    </div>

</div>

@endsection
