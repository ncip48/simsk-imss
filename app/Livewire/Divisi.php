<?php

namespace App\Livewire;

use App\Models\Divisi as ModelsDivisi;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Divisi extends Component
{
    use WithPagination;

    public $nama, $kode, $divisi = null, $isView = false, $isEdit = false;

    public function render()
    {
        $departments = ModelsDivisi::orderBy('departments.id_divisi', 'asc')
            ->paginate(10);
        return view('livewire.divisi.index', [
            'departments' => $departments,
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

    public function saveDivisi()
    {
        if (!$this->isEdit) {
            $this->storeDivisi();
        } else {
            $this->updateDivisi();
        }
    }

    public function storeDivisi()
    {
        $validatedData = $this->validate();

        $divisi = ModelsDivisi::create($validatedData);

        if ($divisi) {
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Divisi berhasil ditambahkan!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Divisi gagal ditambahkan!"
            ]);
        }

        $this->resetInputs();

        $this->dispatch('close-modal');
    }

    private function resetInputs()
    {
        $this->nama = null;
        $this->kode = null;
    }

    public function showDivisi(ModelsDivisi $divisi)
    {
        if ($divisi) {
            $this->divisi = $divisi;
            $this->nama = $divisi->nama;
            $this->kode = $divisi->kode;
            $this->isView = true;
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Divisi tidak ditemukan!"
            ]);
        }
    }

    public function editDivisi(ModelsDivisi $divisi)
    {
        if ($divisi) {
            $this->divisi = $divisi;
            $this->nama = $divisi->nama;
            $this->kode = $divisi->kode;
            $this->isEdit = true;
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Divisi tidak ditemukan!"
            ]);
        }
    }

    public function updateDivisi()
    {
        $validatedData = $this->validate();

        if ($this->divisi) {
            $this->divisi->nama = $validatedData['nama'];
            $this->divisi->kode = $validatedData['kode'];
            $this->divisi->save();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Divisi berhasil diupdate!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Divisi gagal diupdate!"
            ]);
        }

        $this->isEdit = false;

        $this->resetInputs();

        $this->dispatch('close-modal');
    }

    public function deleteDivisi(ModelsDivisi $divisi)
    {
        $this->divisi = $divisi;
    }

    public function destroyDivisi()
    {
        if ($this->divisi) {
            $this->divisi->delete();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Divisi berhasil dihapus!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Divisi gagal dihapus!"
            ]);
        }

        $this->dispatch('close-modal');
    }

    public function closeModal()
    {
        $this->resetInputs();
    }
}
