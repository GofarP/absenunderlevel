<?php

namespace App\Livewire\StatusAbsensi;

use App\Models\StatusAbsensi;
use Livewire\Component;
use Livewire\WithPagination;

class StatusAbsensiIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $search;

    public function render()
    {
        $data_status_absensi = StatusAbsensi::where('nama', 'like', '%' . $this->search . '%')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->onEachSide(1);

        if(count($data_status_absensi)<=10){
            $this->resetPage();
        }

        return view('livewire.status-absensi.status-absensi-index', compact('data_status_absensi'));
    }
}
