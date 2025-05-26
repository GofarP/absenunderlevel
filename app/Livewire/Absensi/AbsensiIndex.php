<?php

namespace App\Livewire\Absensi;

use App\Models\Absensi;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class AbsensiIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = "";
    public function render()
    {
        $data_absensi = Absensi::with(['users', 'statusabsensi', 'shift'])
            ->when(Auth::user()->id != 1, function ($query) {
                $query->where('users_id', Auth::user()->id);
            })
            ->where(function ($query) {
                $query->whereHas('users', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('statusabsensi', function ($q) {
                        $q->where('nama', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('shift', function ($q) {
                        $q->where('nama', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->onEachSide(1);


        return view('livewire.absensi.absensi-index', compact('data_absensi'));
    }
}
