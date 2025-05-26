<?php

namespace App\Livewire\Shift;

use App\Models\Shift;
use Livewire\Component;
use Livewire\WithPagination;

class ShiftIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";
    public $search;

    public function render()
    {
        $data_shift = Shift::where('nama', 'like', '%' . $this->search . '%')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->onEachSide(1);


        if (count($data_shift) <= 10) {
            $this->resetPage();
        }

        return view('livewire.shift.shift-index', compact('data_shift'));
    }
}
