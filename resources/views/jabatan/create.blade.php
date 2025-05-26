@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Jabatan')
@section('page-heading', 'Tambah Jabatan')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('jabatan.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="form-group col-12 mb-3">
                            <label for="nama">Nama:</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                                placeholder="Masukkan nama" value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>



                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

@endsection
