@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Karyawan')
@section('page-heading', 'Tambah Karyawan')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                         <div class="form-group col-12 mb-3">
                            <label for="name">NIP:</label>
                            <input type="number" class="form-control @error('nip') is-invalid @enderror" name="nip"
                                placeholder="Masukkan NIP Pegawai" value="{{ old('nip') }}">
                            @error('nip')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="name">Nama:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                placeholder="Masukkan nama" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                placeholder="Masukkan email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="jabatan_id">Jabatan:</label>
                            <select name="jabatan_id" id="jabatan_id"
                                class="form-control @error('jabatan_id') is-invalid @enderror js-example-basic-single ">
                                <option value="">Silahkan Pilih Jabatan</option>
                                @foreach ($data_jabatan as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('jabatan_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jabatan_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form-group col-12 mb-3">
                            <label for="cabang_id">Cabang:</label>
                            <select name="cabang_id" id="cabang_id"
                                class="form-control @error('cabang_id') is-invalid @enderror js-example-basic-single ">
                                <option value="">Silahkan Pilih Cabang</option>
                                @foreach ($data_cabang as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('cabang_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cabang_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="shift_id">Shift:</label>
                            <select name="shift_id" id="shift_id"
                                class="form-control @error('shift_id') is-invalid @enderror js-example-basic-single ">
                                <option value="">Silahkan Pilih Shift</option>
                                @foreach ($data_shift as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('shift_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('shift_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form-group col-12 mb-3">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" placeholder="Masukkan Password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="password_confirmation">Konfirmasi Password:</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation" placeholder="Konfirmasi Password">
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="foto">Foto (max 2mb):</label>
                            <input type="file" name="foto" id="foto"
                                class="form-control @error('foto') is-invalid @enderror">
                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Preview -->
                    <div class="mt-3">
                        <img id="preview" src="#" alt="Preview Foto" style="max-height: 200px; display: none;">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('preview');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.style.display = 'block';
                        preview.src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush
@endsection
