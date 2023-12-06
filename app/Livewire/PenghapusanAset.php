<?php

namespace App\Livewire;

use Livewire\Component;

class PenghapusanAset extends Component
{
    public function render()
    {
        // $history = PenghapusanAset::orderBy('penghapusan_aset.id', 'asc')
        //     ->paginate(10);

        return view(
            'livewire.penghapusan-aset.index',
            // [
            //     'history' => $history,
            // ]
        );
    }

    public function filter()
    {
        // $history = PenghapusanAset::where('tipe', $this->tipe)
        //     ->whereYear('tanggal', $this->year)
        //     ->orderBy('penghapusan_aset.id', 'asc')
        //     ->paginate(10);
        // return view(
        //     'livewire.penghapusan-aset.index',
        //     [
        //         'history' => $history,
        //     ]
        // );
    }
}
