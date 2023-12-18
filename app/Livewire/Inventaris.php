<?php

namespace App\Livewire;

use App\Models\Aset;
use App\Models\Aset as ModelsAset;
use App\Models\PenghapusanAset;
use App\Models\KodeAset;
use Livewire\Component;
use Livewire\WithPagination;

class Inventaris extends Component
{
    use WithPagination;
    public $kode_asets = [];
    public $tipeUrl = 'tanah';
    public $kode_aset = '180-1';
    public $type, $jenis_aset,$merek,$no_seri,$keterangan, $aset_id = 1, $pengguna, $tanggal_perolehan, $kondisi, $lokasi, $aset=null, $isView = false, $isEdit = false;

    public function render()
    {
        $asets = Aset::where('aset_id', $this->aset_id)
            ->where('tipe', 2) // 2 = inventaris
            ->orderBy('asets.id', 'asc')
            ->paginate(10);
        $this->kode_asets = KodeAset::all();
        return view(
            'livewire.inventaris.index',
            [
                'asets' => $asets,
                'tipe' => strtoupper($this->tipeUrl),
            ]
        );
    }

    public function changeTipe(KodeAset $type)
    {
        // dd($type);
        $this->tipeUrl = $type->nama;
        $this->aset_id = $type->id;
        $this->kode_aset = $type->kode;
    }

    protected $rules = [
        'jenis_aset' => 'required',
        'tanggal_perolehan' => 'required',
        'merek' => 'nullable',
        'no_seri' => 'nullable',
        'kondisi' => 'required',
        'lokasi' => 'required',
        'pengguna' => 'nullable',
        'keterangan' => 'nullable',

    ];

    protected $messages = [
        'jenis_aset.required' => 'Jenis aset tidak boleh kosong.',
        'tanggal_perolehan.required' => 'Tanggal Perolehan tidak boleh kosong.',
        'kondisi.required' => 'Kondisi tidak boleh kosong.',
        'lokasi.required' => 'Lokasi tidak boleh kosong.',
    ];

    public function updated($inputs)
    {
        $this->validateOnly($inputs);
    }

    public function saveAsset()
    {
        if (!$this->isEdit) {
            $this->storeAsset();
        } else {
            $this->updateAsset();
        }
    }

    public function storeAsset()
    {
        $validatedData = $this->validate();
        $validatedData['aset_id'] = $this->aset_id;

        //get tge $this->tanggal_perolehan year
        $this_year = date('Y', strtotime($this->tanggal_perolehan));
        $count = ModelsAset::where('aset_id', $this->aset_id);
        if ($count->count() == 0) {
            $count = 1;
        } else {
            //get the last id then add 1
            $count = $count->latest()->first()->nomor_aset;
            $count = explode('/', $count)[0];
            $count = $count + 1;
        }

        //add 00 in count example 001, 002 with str_pad 
        $count = str_pad($count, 3, '0', STR_PAD_LEFT);

        $validatedData['nomor_aset'] = $count . '/' . $this->kode_aset . '/UMUM/' . $this_year;
        $validatedData['tipe'] = 2;

        // dd($validatedData);

        $aset = ModelsAset::create($validatedData);
        if ($aset) {
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Aset berhasil ditambahkan!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'danger',
                'message' => "Aset gagal ditambahkan!"
            ]);
        }
        $this->resetInputs();
        $this->dispatch('close-modal');
    }

    public function editAset(ModelsAset $aset)
    {
        if ($aset) {
            $this->isEdit = true;
            $this->aset_id = $aset->aset_id;
            $this->aset = $aset;
            $this->jenis_aset = $aset->jenis_aset;
            $this->merek = $aset->merek;
            $this->no_seri = $aset->no_seri;
            $this->tanggal_perolehan = $aset->tanggal_perolehan;
            $this->kondisi = $aset->kondisi;
            $this->lokasi = $aset->lokasi;
            $this->pengguna = $aset->pengguna;
            $this->keterangan = $aset->keterangan;
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Aset tidak ditemukan!"
            ]);
        }
    }

    public function updateAsset()
    {
        $validatedData = $this->validate();
        if ($this->aset){
            $this->aset->jenis_aset = $validatedData['jenis_aset'];
            $this->aset->merek = $validatedData['merek'];
            $this->aset->no_seri = $validatedData['no_seri'];
            $this->aset->kondisi = $validatedData['kondisi'];
            $this->aset->lokasi = $validatedData['lokasi'];
            $this->aset->pengguna = $validatedData['pengguna'];
            $this->aset->tanggal_perolehan = $validatedData['tanggal_perolehan'];
            $this->aset->keterangan = $validatedData['keterangan'];
            $this->aset->save();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Aset berhasil diupdate!"
            ]);
        }else{
            $this->dispatch('alert', [
                'type' => 'danger',
                'message' => "Aset gagal diupdate!"
            ]);
        }

        $this->isEdit = false;
        $this->resetInputs();
        $this->dispatch('close-modal');
    }

    public function deleteAset(ModelsAset $aset)
    {
        $this->aset = $aset;
    }

    public function destroyAset(ModelsAset $aset)
    {
        $aset = $this->aset;
        PenghapusanAset::insert([
            'kode_aset_id' => $aset->aset_id,
            'tipe' => $aset->tipe,
            'nomor_aset' => $aset->nomor_aset,
            'jenis_aset' => $aset->jenis_aset,
            'merek' => $aset->merek,
            'no_seri' => $aset->no_seri,
            'kondisi' => $aset->kondisi,
            'tanggal_perolehan' => $aset->tanggal_perolehan,
            'lokasi' => $aset->lokasi,
            'pengguna' => $aset->pengguna,
            'keterangan' => $aset->keterangan,
        ]);

        if ($this->aset) {
            $this->aset->delete();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Aset berhasil dihapus!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'danger',
                'message' => "Aset gagal dihapus!"
            ]);
        }

        $this->dispatch('close-modal');
    }

    public $fileUpload;
    // public function importAset(Request $request)
    // {
    //     $this->validate([
    //         'fileUpload' => 'required|mimes:xls,xlsx'
    //     ]);

    //     $file = $this->fileUpload;
    //     $fileName = time() . '.' . $file->getClientOriginalExtension();
    //     $file->storeAs('public', $fileName);

    //     // Excel::import(new \App\Imports\AsetImport, $fileName);

    //     // $this->dispatch('alert', [
    //     //     'type' => 'success',
    //     //     'message' => "Aset berhasil diimport!"
    //     // ]);
    //     return $this->dispatch('alert', [
    //         'type' => 'info',
    //         'message' => "Fitur masih dalam tahap pengembangan, see u~"
    //     ]);
    // }

    public function export()
    {
        return $this->dispatch('alert', [
            'type' => 'info',
            'message' => "Fitur masih dalam tahap pengembangan, see u~"
        ]);
    }

    public function closeModal()
    {
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->reset(['jenis_aset','tanggal_perolehan','merek','no_seri','keterangan','pengguna','kondisi','lokasi']);

    }
}

