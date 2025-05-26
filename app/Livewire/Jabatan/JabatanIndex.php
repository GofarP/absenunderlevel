<?php

namespace App\Livewire\Jabatan;

use App\Models\Jabatan;
use Livewire\Component;
use Livewire\WithPagination;

class JabatanIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search;

    public function render()
    {
        $data_jabatan = Jabatan::where('nama', 'like', '%' . $this->search . '%')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->onEachSide(1);

        if (count($data_jabatan) <= 10) {
            $this->resetPage();
        }

        return view('livewire.jabatan.jabatan-index', compact('data_jabatan'));
    }
}
