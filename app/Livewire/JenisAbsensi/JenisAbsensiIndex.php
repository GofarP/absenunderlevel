<?php

namespace App\Livewire\JenisAbsensi;

use App\Models\JenisAbsensi;
use Livewire\Component;
use Livewire\WithPagination;

class JenisAbsensiIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search;

    public function render()
    {
        $data_jenis_absensi = JenisAbsensi::where('nama', 'like', '%' . $this->search . '%')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->onEachSide(1);

        if (count($data_jenis_absensi) <= 10) {
            $this->resetPage();
        }

        return view('livewire.jenis-absensi.jenis-absensi-index',compact('data_jenis_absensi'));
    }
}
