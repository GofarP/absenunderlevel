@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Absensi')
@section('page-heading', 'Absensi')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('absensi.update', $absensi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-12 mb-3">
                            <label for="name">Jam Masuk:</label>
                            <input type="time" class="form-control @error('created_at') is-invalid @enderror"
                                name="created_at" value="{{ \Carbon\Carbon::parse($absensi->created_at)->format('H:i') }}">

                            @error('created_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group col-12 mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="lembur" value="1" id="lembur" class="form-check-input"
                                    {{ old('lembur', $gaji->lembur ?? 0) > 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="lembur">Lembur</label>
                            </div>

                        </div>

                    </div>
                    <button type="submit" class="btn btn-warning">Update</button>
                </form>
            </div>
        </div>
    </div>

@endsection
