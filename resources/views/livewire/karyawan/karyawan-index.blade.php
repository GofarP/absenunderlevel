<div>
    <div class="table-responsive">
        <div class="float-right mb-3">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Cari...">

        </div>
        <div class="float-right mb-3" style="clear: both;">
            <a href="{{ route('karyawan.create') }}" class="btn btn-primary">
                <i class="mdi mdi-plus"></i> Tambah Data
            </a>
        </div>
        <table class="table table-bordered" style="color: black;">
            <thead>
                <th style="border: 1px solid; color: black">No</th>
                <th style="border: 1px solid; color: black;">Nama</th>
                <th style="border: 1px solid; color: black;">Jabatan</th>
                <th style="border: 1px solid; color: black;">Cabang</th>
                <th style="border: 1px solid; color: black;">Shift</th>
                <th style="border: 1px solid; color: black;">Gaji Pokok</th>
                <th style="border: 1px solid; color: black;">Lembur</th>
                <th style="border: 1px solid; color: black;">Foto</th>
                <th style="border: 1px solid; color: black;">Action</th>
            </thead>
            <tbody>
                @forelse ($data_karyawan as $item)
                    <tr>
                        <td style="border: 1px solid; color: black;">{{ $loop->iteration }}</td>
                        <td style="border: 1px solid; color: black;">{{ $item->users->name ?? '-' }}</td>
                        <td style="border: 1px solid; color: black;">{{ $item->jabatan->nama ?? '-' }}</td>
                        <td style="border: 1px solid; color: black;">{{ $item->cabang->nama ?? '-' }}</td>
                        <td style="border: 1px solid; color: black;">{{ $item->shift->nama ?? '-' }}</td>
                        <td style="border: 1px solid; color: black;">{{ number_format($item->gaji_pokok) ?? 0 }}</td>
                        <td style="border: 1px solid; color: black;">{{ number_format($item->lembur) ?? 0 }}</td>
                        <td style="border: 1px solid; color: black;">
                            @if ($item->users->foto == '')
                                <img src="{{ asset('/foto_karyawan/images.png') }}" height="100" width="100"
                                    alt="">
                            @else
                                <img src="{{ asset('foto_karyawan/' . $item->users->foto) }}" height="100"
                                    width="100" alt="">
                            @endif
                        </td>
                        <td style="border: 1px solid; color: black;">
                            <div class="d-flex">
                                <a href="{{ route('karyawan.edit', $item->id) }}" class="btn btn-warning mr-2">Edit</a>
                                <form action="{{ route('karyawan.destroy', $item->id) }}" method="POST">
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
                        <td colspan="9" class="text-center" style="border: 1px solid; color: black;">Data Tidak
                            Tersedia Atau Masih Kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="float-right mt-3">
            <div class="pagination pagination-dark">
                {{ $data_karyawan->links() }}
            </div>
        </div>
    </div>
</div>
