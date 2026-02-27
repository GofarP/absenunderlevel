@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Absensi')
@section('page-heading', 'Absensi')
@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-exclamation-circle"></i> Periksa kembali inputan Anda:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form action="{{ route('absensi.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-12 mb-3">
                            <label for="name">Nama:</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ Auth::user()->name }}" readonly>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="jabatan">Jabatan:</label>
                            <input type="text" class="form-control"
                                value="{{ Auth::user()->karyawan->first()?->jabatan?->nama }}" readonly>
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="cabang">Cabang:</label>
                            <input type="text" class="form-control"
                                value="{{ Auth::user()->karyawan->first()?->cabang?->nama }}" readonly>
                            @error('cabang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="shift">Shift:</label>
                            <input type="text" class="form-control"
                                value="{{ Auth::user()->karyawan->first()?->shift?->nama }} ({{ Auth::user()->karyawan->first()?->shift?->mulai_dari }} - {{ Auth::user()->karyawan->first()?->shift?->sampai_dengan }})"
                                readonly>
                            @error('shift')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="status_absensi_id">Status Absensi:</label>
                            <select name="status_absensi_id" id="status_absensi_id"
                                class="form-control @error('status_absensi_id') is-invalid @enderror js-example-basic-single">
                                <option value="">Status Absensi</option>
                                @foreach ($dataStatusAbsensi as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('status_absensi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="lembur" value="1" id="lembur" class="form-check-input"
                                    {{ old('lembur') ? 'checked' : '' }}>
                                <label class="form-check-label" for="lembur">Lembur</label>
                            </div>
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="jenis_absensi_id">Jenis Absensi :</label>
                            <select name="jenis_absensi_id" id="jenis_absensi_id"
                                class="form-control js-example-basic-single @error('jenis_absensi_id') is-invalid @enderror">
                                <option value="">Pilih Jenis Absensi</option>
                                @foreach ($dataJenisAbsensi as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('jenis_absensi_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_absensi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="webcam">Ambil Foto Absensi:</label>
                            <div id="my_camera" class="mb-2"></div>
                            <input type="hidden" name="foto" id="image-tag">
                            <button type="button" onclick="take_snapshot()" class="btn btn-primary mb-3">Ambil
                                Foto</button>

                            <div id="results">Foto akan muncul di sini...</div>
                        </div>

                        <div class="form-group">
                            <label for="map">Lokasi:</label>
                            <div class="mt-2"
                                style="width: 100%; overflow: hidden; border-radius: 8px; border: 1px solid #ddd;">
                                <iframe
                                    src="https://maps.google.com/maps?q={{ $cabang->lattitude }},{{ $cabang->longitude }}&hl=id&z=18&output=embed"
                                    width="100%" height="350" style="border:0; display: block;" allowfullscreen=""
                                    loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                        <input type="hidden" name="lat" id="lat" /><input type="hidden" name="lng"
                            id="lng">

                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- WebcamJS CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            getLocation();
        });

        function getLocation() {
            if (navigator.geolocation) {
                var options = {
                    enableHighAccuracy: true,
                    timeOut: 5000,
                    maximumAge: 0
                };

                navigator.geolocation.getCurrentPosition(showPosition, showError, options);
            } else {
                alert("Geolocation tidak didukung oleh browser ini");
            }
        }

        function showPosition(position) {
            document.getElementById("lat").value = position.coords.latitude;
            document.getElementById("lng").value = position.coords.longitude;
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("Anda menolak izin lokasi! Absensi tidak bisa dilakukan tanpa lokasi.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Informasi lokasi tidak tersedia.");
                    break;
                case error.TIMEOUT:
                    alert("Waktu permintaan lokasi habis. Coba refresh halaman.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("Terjadi kesalahan yang tidak diketahui.");
                    break;
            }
        }
    </script>

    <script language="JavaScript">
        // Setting Webcam
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach('#my_camera');

        // Fungsi untuk ambil foto
        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                document.getElementById('image-tag').value = data_uri;
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '" class="img-fluid"/>';
            });
        }
    </script>
@endpush
