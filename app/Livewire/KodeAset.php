<?php

namespace App\Livewire;

use App\Models\KodeAset as ModelsKodeAset;
use Livewire\Component;
use Livewire\WithPagination;

class KodeAset extends Component
{
    use WithPagination;
    public $nama, $kode, $kode_aset = null, $isView = false, $isEdit = false;

    public function render()
    {
        $kode_asets = ModelsKodeAset::orderBy('kode_aset.id', 'asc')
            ->paginate(10);
        return view('livewire.kode-aset.index', 
        [
            'kode_asets' => $kode_asets,
        ]);
    }
    protected $rules = [
        'nama' => 'required',
        'kode' => 'required',
    ];

    protected $messages = [
        'nama.required' => 'Nama tidak boleh kosong.',
        'kode.required' => 'Kode tidak boleh kosong.',
    ];

    public function updated($inputs)
    {
        $this->validateOnly($inputs);
    }

    public function saveKodeAset()
    {
        if (!$this->isEdit) {
            $this->storeKodeAset();
        } else {
            $this->updateKodeAset();
        }
    }

    public function storeKodeAset()
    {
        $validatedData = $this->validate();
        $kode_aset = ModelsKodeAset::create($validatedData);
        if ($kode_aset) {
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Kode Aset berhasil ditambahkan!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'danger',
                'message' => "Kode Aset gagal ditambahkan!"
            ]);
        }
        $this->resetInputs();

        // $this->emit('kodeAsetStored', $kode_aset);
        $this->dispatch('close-modal');
    }

    public function resetInputs()
    {
        $this->nama = null;
        $this->kode = null;
        $this->isEdit = false;
    }

    public function editKodeAset(ModelsKodeAset $kode_aset)
    {
        if ($kode_aset) {
            // $this->showModalEdit($kode_aset);
            $this->kode_aset = $kode_aset;
            $this->nama = $kode_aset->nama;
            $this->kode = $kode_aset->kode;
            $this->isEdit = true;
        }else{
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Kode Aset tidak ditemukan!"
            ]);
        }
        // $this->dispatch('open-modal');
    }

    public function updateKodeAset()
    {
        $validatedData = $this->validate();
        if ($this->kode_aset) {
            $this->kode_aset->update($validatedData);
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Kode Aset berhasil diupdate!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'danger',
                'message' => "Kode Aset gagal diupdate!"
            ]);
        }
        $this->resetInputs();
        $this->dispatch('close-modal');
    }

    public function deleteKodeAset(ModelsKodeAset $kode_aset)
    {
        $this->kode_aset = $kode_aset;
    }

    public function destroyKodeAset()
    {
        if ($this->kode_aset) {
            $this->kode_aset->delete();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Kode Aset berhasil dihapus!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'danger',
                'message' => "Kode Aset gagal dihapus!"
            ]);
        }
        $this->resetInputs();
        $this->dispatch('close-modal');
    }

    public function closeModal()
    {
        $this->resetInputs();
    }
}
