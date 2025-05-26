@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Status Absensi')
@section('page-heading', 'Edit Status Absensi')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('statusabsensi.update',$statusabsensi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-12 mb-3">
                            <label for="name">Nama:</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                                placeholder="Masukkan nama" value="{{ old('nama') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>



                    </div>

                    <button type="submit" class="btn btn-warning">Update</button>
                </form>
            </div>
        </div>
    </div>

@endsection
