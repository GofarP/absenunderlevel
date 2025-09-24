@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Absensi')
@section('page-heading', 'Absensi')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
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
                                @foreach ($data_status_absensi as $item)
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
                                @foreach ($data_jenis_absensi as $item)
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
