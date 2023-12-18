<?php

namespace App\Livewire;

use App\Models\Aset;
use App\Models\KodeAset;
use App\Models\PenghapusanAset as ModelsPenghapusanAset;
use Livewire\Component;

class PenghapusanAset extends Component
{
    public $tipe;
    public $tahun;
    public $kode_asets;
    public $tahuns;

    public $tipeOptions = [
        [
            'id' => 1,
            'nama' => 'Aset',
        ],
        [
            'id' => 2,
            'nama' => 'Inventaris',
        ]
    ];

    public function mount()
    {
        $this->tahuns = ModelsPenghapusanAset::selectRaw('YEAR(tanggal_perolehan) as tahun')->distinct()->pluck('tahun')->sort();
        $this->tahuns = $this->tahuns->map(function ($item) {
            return $item;
        });

        $this->tipeOptions = collect($this->tipeOptions)->map(function ($item) {
            return (object) $item;
        });
    }

    public function render()
    {
        $history = ModelsPenghapusanAset::when($this->tahun, function ($query) {
            $query->whereYear('tanggal_perolehan', $this->tahun);
        })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view(
            'livewire.penghapusan-aset.index',
            [
                'history' => $history,
            ]
        );
    }

    public function filter()
    {
        // $history = ModelsPenghapusanAset::where('tipe', $this->tipe)
        //     ->when($this->tahun, function ($query) {
        //         $query->whereYear('tanggal_perolehan', $this->tahun);
        //     })
        //     ->orderBy('id', 'asc')
        //     ->paginate(10);

        // dd($history);   

        // return view(
        //     'livewire.penghapusan-aset.index',
        //     [
        //         'history' => $history,
        //     ]
        // );

        $query = ModelsPenghapusanAset::query();
        if ($this->tipe) {
            $query->where('tipe', $this->tipe);
        }
        if ($this->tahun) {
            $query->whereYear('tanggal_perolehan', $this->tahun);
        }

        $history = $query->orderBy('id', 'asc')->paginate(10);

        // dd($history);         

        return view(
            'livewire.penghapusan-aset.index',
            [
                'history' => $history,
            ]
        );
    }

    public function export()
    {
        // return redirect()->route('penghapusan-aset.export', [
        //     'tipe' => $this->tipe,
        //     'tahun' => $this->tahun,
        // ]);

        //alert success
        return $this->dispatch('alert', [
            'type' => 'info',
            'message' => "Fitur masih dalam tahap pengembangan, see u~"
        ]);
    }
}
