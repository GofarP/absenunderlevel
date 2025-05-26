<div>
    <div class="table-responsive">
        <div class="float-right mb-3">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Cari...">

        </div>
        <div class="float-right mb-3" style="clear: both;">
            <a href="{{ route('shift.create') }}" class="btn btn-primary">
                <i class="mdi mdi-plus"></i> Tambah Data
            </a>
        </div>
        <table class="table table-bordered" style="color: black;">
            <thead>
                <th style="border: 1px solid; color: black">No</th>
                <th style="border: 1px solid; color: black;">Nama</th>
                <th style="border: 1px solid; color: black;">Mulai Dari</th>
                <th style="border: 1px solid; color: black;">Sampai Dengan</th>
                <th style="border: 1px solid; color: black;">Action</th>
            </thead>
            <tbody>
                @forelse ($data_shift as $item)
                    <tr>
                        <td style="border: 1px solid; color: black;">{{ $loop->iteration }}</td>
                        <td style="border: 1px solid; color: black;">{{ $item->nama }}</td>
                        <td style="border: 1px solid; color: black;">{{ $item->mulai_dari }}</td>
                        <td style="border: 1px solid; color: black;">{{ $item->sampai_dengan }}</td>

                        <td style="border: 1px solid; color: black;">
                            <div class="d-flex">
                                <a href="{{ route('shift.edit',$item->id) }}" class="btn btn-warning mr-2">Edit</a>
                                <form action="{{ route('shift.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda Ingin Menghapus Data Ini')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center" style="border: 1px solid; color: black;">Data Tidak
                            Tersedia Atau Masih Kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="float-right mt-3">
            <div class="pagination pagination-dark">
            {{ $data_shift->links() }}
            </div>
        </div>
    </div>
</div>
