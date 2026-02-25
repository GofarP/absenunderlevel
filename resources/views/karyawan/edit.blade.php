@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Karyawan')
@section('page-heading', 'Edit Karyawan')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-12 mb-3">
                            <label for="name">NIP:</label>
                            <input type="number" class="form-control @error('nip') is-invalid @enderror" name="nip"
                                placeholder="Masukkan NIP Pegawai" value="{{ old('nip', $karyawan->nip) }}">
                            @error('nip')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-12 mb-3">
                            <label for="name">Nama:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name', $karyawan->users->name) }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email', $karyawan->users->email) }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="jabatan_id">Jabatan:</label>
                            <select name="jabatan_id" id="jabatan_id"
                                class="form-control @error('jabatan_id') is-invalid @enderror js-example-basic-single">
                                <option value="">Silahkan Pilih Jabatan</option>
                                @foreach ($data_jabatan as $item)
                                    <option value="{{ $item->id }}" {{ old('jabatan_id', $karyawan->jabatan_id) == $item->id ? 'selected' : '' }}>
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
                                class="form-control @error('cabang_id') is-invalid @enderror js-example-basic-single">
                                <option value="">Silahkan Pilih Cabang</option>
                                @foreach ($data_cabang as $item)
                                    <option value="{{ $item->id }}" {{ old('cabang_id', $karyawan->cabang_id) == $item->id ? 'selected' : '' }}>
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
                                        {{ $karyawan->shift_id == $item->id ? 'selected' : '' }}>
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
                            <label for="foto">Foto(max 2mb):</label>
                            <input type="file" name="foto" id="foto"
                                class="form-control @error('foto') is-invalid @enderror" onchange="previewImage(event)">
                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        @if ($karyawan->users->foto)
                            <div class="mt-3">
                                <img id="preview" src="{{ asset('foto_karyawan/' . $karyawan->users->foto) }}" alt="Preview Foto" style="max-height: 200px;">
                            </div>
                        @else
                            <div class="mt-3">
                                <img id="preview" src="#" alt="Preview Foto" style="max-height: 200px; display: none;">
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
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
