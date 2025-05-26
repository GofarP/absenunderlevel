<?php

namespace App\Livewire\Karyawan;

use App\Models\Karyawan;
use Livewire\Component;

use Livewire\WithPagination;

class KaryawanIndex extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public function render()
    {
        $data_karyawan = Karyawan::with('users', 'jabatan', 'cabang')
            ->where('users_id', '!=', 1)
            ->where(function ($query) {
                $query->whereHas('users', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('jabatan', function ($q) {
                        $q->where('nama', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('cabang', function ($q) {
                        $q->where('nama', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('gaji_pokok', 'like', '%' . $this->search . '%')
                    ->orWhere('lembur', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->onEachSide(1);


        if (count($data_karyawan) <= 10) {
            $this->resetPage();
        }

        return view('livewire.karyawan.karyawan-index', compact('data_karyawan'));
    }
}
