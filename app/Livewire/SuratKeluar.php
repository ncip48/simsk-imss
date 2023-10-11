<?php

namespace App\Livewire;

use App\Models\SuratKeluar as ModelsSuratKeluar;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class SuratKeluar extends Component
{
    use WithPagination, WithFileUploads;

    public $type, $no_surat, $tujuan, $uraian, $id_user, $file, $created_at, $status, $suratKeluar = null, $isView = false, $isEdit = false;

    public $tipeUrl = 'd1';

    public function render()
    {
        $this->type = $this->tipeUrl;
        $letters = ModelsSuratKeluar::where('letters.type', 'like', '%' . $this->tipeUrl . '%')
            ->leftJoin('users', 'users.id', '=', 'letters.id_user')
            ->leftJoin('departments', 'departments.id_divisi', '=', 'users.id_divisi')
            ->select('letters.*', 'users.name as nama_user', 'users.id as id_user', 'departments.nama as nama_divisi', 'departments.id_divisi', 'departments.kode as kode_divisi')
            ->orderBy('letters.id', 'asc')
            ->paginate(10);

        return view('livewire.surat-keluar.index', [
            'letters' => $letters,
            'tipe' => strtoupper($this->tipeUrl)
        ]);
    }

    public function changeTipe($type)
    {
        $this->tipeUrl = $type;
        $this->type = $type;
    }

    protected $rules = [
        'type' => 'required',
        'tujuan' => 'required',
        'uraian' => 'required',
    ];

    protected $messages = [
        'type.required' => 'Jenis Surat tidak boleh kosong.',
        'tujuan.required' => 'Tujuan tidak boleh kosong.',
        'uraian.required' => 'Uraian tidak boleh kosong.',
    ];

    public function updated($inputs)
    {
        $this->validateOnly($inputs);
    }

    public function saveSurat()
    {
        if (!$this->isEdit) {
            $this->storeSurat();
        } else {
            $this->updateSurat();
        }
    }

    public function mount()
    {
        $this->type = request()->query('type');
    }

    private function createRomawi($angka)
    {
        $angka = (int)$angka;
        $hasil = "";
        $romawi = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        );
        foreach ($romawi as $rom => $nilai) {
            $matches = intval($angka / $nilai);
            $hasil .= str_repeat($rom, $matches);
            $angka = $angka % $nilai;
        }
        return $hasil;
    }

    public function storeSurat()
    {
        $validatedData = $this->validate();

        //get count surat
        $count = ModelsSuratKeluar::where('type', $validatedData['type'])->count() + 1;

        //get romawi bulan ini
        $romawi = $this->createRomawi(date('m'));

        //get tahun ini
        $year = date('Y');

        //uppercase type
        $type = strtoupper($validatedData['type']);

        //append no surat dengan format $count/$romawi/$type/IMSS/$year
        $validatedData['no_surat'] = $count . '/' . $romawi . '/' . $type . '/IMSS/' . $year;

        $validatedData['id_user'] = auth()->user()->id;

        $surat = ModelsSuratKeluar::create($validatedData);

        if ($surat) {
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "SuratKeluar berhasil ditambahkan!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "SuratKeluar gagal ditambahkan!"
            ]);
        }

        $this->resetInputs();

        $this->dispatch('close-modal');
    }

    private function resetInputs()
    {
        $this->no_surat = null;
        $this->tujuan = null;
        $this->uraian = null;
        $this->id_user = null;
        $this->created_at = null;
        $this->status = null;
    }

    public function showSurat(ModelsSuratKeluar $suratKeluar)
    {
        if ($suratKeluar) {
            $this->suratKeluar = $suratKeluar;
            $this->type = $suratKeluar->type;
            $this->no_surat = $suratKeluar->no_surat;
            $this->tujuan = $suratKeluar->tujuan;
            $this->uraian = $suratKeluar->uraian;
            $this->id_user = $suratKeluar->id_user;
            $this->created_at = $suratKeluar->created_at;
            $this->status = $suratKeluar->status;
            $this->isView = true;
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Surat tidak ditemukan!"
            ]);
        }
    }

    public function editSurat(ModelsSuratKeluar $suratKeluar)
    {
        if ($suratKeluar) {
            $this->suratKeluar = $suratKeluar;
            $this->type = $suratKeluar->type;
            $this->no_surat = $suratKeluar->no_surat;
            $this->tujuan = $suratKeluar->tujuan;
            $this->uraian = $suratKeluar->uraian;
            $this->id_user = $suratKeluar->id_user;
            $this->created_at = $suratKeluar->created_at;
            $this->status = $suratKeluar->status;
            $this->isEdit = true;
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Surat tidak ditemukan!"
            ]);
        }
    }

    public function updateSurat()
    {
        $validatedData = $this->validate();

        //detect the request->file with name 'file'
        $file = $this->file;

        if ($file) {
            //set file name with format $no_surat.$file->extension()
            $fileName = $this->no_surat . '.' . $file->extension();

            //store file to public folder with name $fileName
            $file->storeAs('public/docs', $fileName);

            //set file name to $validatedData['file']
            $validatedData['file'] = $fileName;
        }

        if ($this->suratKeluar) {
            $this->suratKeluar->type = $validatedData['type'];
            $this->suratKeluar->tujuan = $validatedData['tujuan'];
            $this->suratKeluar->uraian = $validatedData['uraian'];
            $this->suratKeluar->file = $validatedData['file'] ?? null;
            $this->suratKeluar->status = $file ? 1 : 0;
            $this->suratKeluar->save();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Surat berhasil diupdate!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Surat gagal diupdate!"
            ]);
        }

        $this->isEdit = false;

        $this->resetInputs();

        $this->dispatch('close-modal');
    }

    public function deleteSurat(ModelsSuratKeluar $suratKeluar)
    {
        $this->suratKeluar = $suratKeluar;
    }

    public function destroySurat()
    {
        if ($this->suratKeluar) {
            $this->suratKeluar->delete();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Surat berhasil dihapus!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Surat gagal dihapus!"
            ]);
        }

        $this->dispatch('close-modal');
    }

    public function closeModal()
    {
        $this->resetInputs();
    }
}
