@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Absensi')
@section('page-heading', 'Data Absensi')
@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (Auth::user()->karyawan->first()?->jabatan?->nama != 'Administrator')

            <div class="card">
                <div class="card-body text-center">
                    <h3>Absensi Hari Ini</h3>

                    <p class="text-muted">
                        {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                    </p>

                    {{-- KONDISI 1: Belum Absen Masuk --}}
                    @if ($cekAbsenMasuk == null)
                        <div class="alert alert-warning">
                            Anda belum melakukan absensi masuk.
                        </div>

                        {{-- Kirim parameter 'tipe=masuk' ke halaman create --}}
                        <a href="{{ route('absensi.create', ['tipe' => 'masuk']) }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt"></i> Absen Masuk
                        </a>

                        {{-- KONDISI 2: Sudah Masuk, Belum Keluar --}}
                    @elseif ($cekAbsenKeluar == null)
                        <div class="alert alert-info">
                            Terima kasih, Anda sudah absen masuk pukul
                            <strong>{{ \Carbon\Carbon::parse($cekAbsenMasuk->created_at)->format('H:i') }}</strong>.
                            <br>Selamat Bekerja! Jangan lupa absen pulang nanti.
                        </div>

                        {{-- Kirim parameter 'tipe=keluar' ke halaman create --}}
                        <a href="{{ route('absensi.create', ['tipe' => 'keluar']) }}" class="btn btn-danger btn-lg">
                            <i class="fas fa-sign-out-alt"></i> Absen Pulang
                        </a>

                        {{-- KONDISI 3: Sudah Selesai Semua --}}
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle fa-2x mb-2"></i><br>
                            <strong>Absensi Tuntas!</strong><br>
                            Anda sudah menyelesaikan jam kerja hari ini.
                        </div>
                        <div class="row mt-3">
                            <div class="col-6 text-right border-right">
                                <small>Masuk</small><br>
                                <strong>{{ \Carbon\Carbon::parse($cekAbsenMasuk->created_at)->format('H:i') }}</strong>
                            </div>
                            <div class="col-6 text-left">
                                <small>Pulang</small><br>
                                <strong>{{ \Carbon\Carbon::parse($cekAbsenKeluar->created_at)->format('H:i') }}</strong>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        <div class="card mt-5">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table table-hover table-stripped">
                        @livewire('absensi.absensi-index')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection