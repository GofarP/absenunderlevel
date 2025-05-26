<div>
    <div class="table-responsive">
        <div class="float-right mb-3">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Cari...">
        </div>
        <table class="table table-bordered" style="color: black;">
            <thead>
                <th style="border: 1px solid; color: black">No</th>
                <th style="border: 1px solid; color: black;">Nama</th>
                <th style="border: 1px solid; color: black;">Status Absensi</th>
                <th style="border: 1px solid; color: black;">Shift</th>
                <th style="border: 1px solid; color: black;">Waktu Absen</th>
                <th style="border: 1px solid; color: black;">Foto</th>
                <th style="border: 1px solid; color: black;">Action</th>
            </thead>
            <tbody>
                @forelse ($data_absensi as $item)
                    <tr>
                        <td style="border: 1px solid; color: black;">{{ $loop->iteration }}</td>
                        <td style="border: 1px solid; color: black;">{{ $item->users->name }}</td>
                        <td style="border: 1px solid; color: black;">{{ $item->statusabsensi->nama }}</td>
                        <td style="border: 1px solid; color: black;">{{ $item->shift->nama }}</td>
                        <td style="border: 1px solid; color: black;">
                            {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td>
                        <td style="border: 1px solid; color: black;">
                            @if ($item->foto != null)
                                <img src="{{ asset('foto_absensi/' . $item->foto) }}" width="100" height="100"
                                    alt="">
                            @else
                                <img src="{{ asset('foto_karyawan/images.png') }}" class="img-fluid" alt="">
                            @endif
                        </td>

                        <td style="border: 1px solid; color: black;">
                            <div class="d-flex">

                                @if (Auth::user()->karyawan->first()?->jabatan?->nama == 'Administrator')
                                    <a href="{{ route('absensi.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                                @endif

                                <form action="{{ route('absensi.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Apakah Anda Ingin Menghapus Data Ini')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center" style="border: 1px solid; color: black;">Data Tidak
                            Tersedia Atau Masih Kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="float-right mt-3">
            <div class="pagination pagination-dark">
                {{ $data_absensi->links() }}
            </div>
        </div>
    </div>
</div>
