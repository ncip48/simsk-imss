<?php

namespace App\Livewire;

use App\Imports\SuratImport;
use App\Models\SuratKeluar as ModelsSuratKeluar;
use Carbon\Carbon;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

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
        'file' => 'nullable|max:2048',
        'fileUpload' => 'nullable|max:2048',
        'created_at' => 'required|date'
    ];

    protected $messages = [
        'type.required' => 'Jenis Surat tidak boleh kosong.',
        'tujuan.required' => 'Tujuan tidak boleh kosong.',
        'uraian.required' => 'Uraian tidak boleh kosong.',
        'file.max' => 'File maksimal 2MB.',
        'fileUpload.max' => 'File maksimal 2MB.',
        'created_at.required' => 'Tanggal Surat tidak boleh kosong.',
        'created_at.date' => 'Tanggal Surat harus berupa tanggal.'
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

    public $fileUpload;
    public function importSurat()
    {
        $file = $this->fileUpload;

        $collection = Excel::toCollection(new SuratImport, $file);

        $collection = $collection[0];

        $headers = [
            'tanggal_surat',
            'nomor_surat',
            'tujuan',
            'uraian',
            'pic',
            'arsip_elektronik',
            'type'
        ];

        //remove index 0
        $collection->shift();
        $collection->shift();

        $collection = $collection->map(function ($item) {
            $item = $item->toArray();
            return $item;
        });

        //looping then remove every index 2 where null
        foreach ($collection as $key => $value) {
            if ($value[2] == null) {
                $collection->forget($key);
            }
        }

        //remove index 0, 7-29 in $collections->item
        $collection = $collection->map(function ($item) use ($headers) {
            //remove $item[0], $item[7-29]
            $item = array_slice($item, 1, 6);
            //change 45191.0 with date
            $item[0] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[0])->format('Y-m-d');
            //add type in index 7
            $item[5] = $item[5] == 'Ada' ? 1 : 0;
            $item[6] = 'd1';
            return $item;
        });


        dd($collection);


        return $this->dispatch('alert', [
            'type' => 'info',
            'message' => "Fitur masih dalam tahap pengembangan, see u~"
        ]);
    }

    public function incrementSubNomor($start)
    {
        $end = 'Z';

        //increment sub nomor A-Z

        $sub = $start;

        if ($sub == null) {
            return 'A';
        }

        $sub++;

        if ($sub == $end) {
            $sub = 'A';
        }

        return $sub;
    }

    public function storeSurat()
    {
        $validatedData = $this->validate();

        //find latest surat keluar, if type 0 then return
        $latestSurat = ModelsSuratKeluar::where('type', $this->type)->where('status', '0')
            ->orderBy('id', 'desc')->latest()->first();

        if ($latestSurat) {
            if ($latestSurat->status == 0) {
                $this->dispatch('alert', [
                    'type' => 'error',
                    'message' => "Surat sebelumnya belum diupload! Mohon hubungi PIC sebelumnya."
                ]);
                return;
            }
        }

        //get count surat
        $count = ModelsSuratKeluar::where('type', $validatedData['type']);

        if ($count->count() == 0) {
            $count = 1;
        } else {
            //ambil no_surat lalu explode / index 0
            $count = $count->latest()->first()->no_surat;
            $count = explode('/', $count)[0] + 1;
        }

        //format count 001, dll until 100
        $count = str_pad($count, 3, '0', STR_PAD_LEFT);

        //get romawi bulan ini
        $romawi = $this->createRomawi(date('m', strtotime($this->created_at)));

        //get tahun ini
        $year = date('Y');

        //uppercase type
        $type = strtoupper($validatedData['type']);

        //append no surat dengan format $count/$romawi/$type/IMSS/$year

        //found the SuratKeluar where created_at = $this->created_at

        $check_date = ModelsSuratKeluar::whereDate('created_at', $this->created_at)->count();

        $date_now = Carbon::now()->format('Y-m-d');

        if ($check_date > 0 && $this->created_at != $date_now) {

            //check by date and type
            $count_check = ModelsSuratKeluar::whereDate('created_at', $this->created_at)
                ->where('type', $this->type)
                ->latest()->first();

            if ($count_check) {
                if ($count_check->status == 0) {
                    $this->dispatch('alert', [
                        'type' => 'error',
                        'message' => "Surat sebelumnya belum diupload! Mohon hubungi PIC sebelumnya."
                    ]);
                    return;
                }
            }

            $romawi = $this->createRomawi(date('m', strtotime($this->created_at)));
            //find latest surat keluar with date $this->created_at then get sub nomor, if not found then return A
            $latestSurat = ModelsSuratKeluar::whereDate('created_at', $this->created_at)
                ->orderBy('id', 'desc')
                ->latest()->first();
            $sub = $latestSurat->no_surat;
            //pecah $sub dengan 3 karakter didepan misal 001A maka ambil A
            $sub = substr($sub, 3, 1);

            if ($sub == '/') {
                $sub = null;
            } else {
                $sub = $sub;
            }
            $increment_sub = $this->incrementSubNomor($sub);
            // dd($increment_sub);
            $count = $latestSurat->no_surat;
            $count = explode('/', $count)[0];
            //get the 3 digit number
            $count = substr($count, 0, 3);
            $romawi = $this->createRomawi(date('m', strtotime($this->created_at)));
            $validatedData['no_surat'] = $count . $increment_sub . '/' . $romawi . '/' . $type . '/IMSS/' . $year;
        } else {
            $validatedData['no_surat'] = $count . '/' . $romawi . '/' . $type . '/IMSS/' . $year;
        }


        $validatedData['id_user'] = auth()->user()->id;

        $validatedData['file'] = null;

        $validatedData['created_at'] = $this->created_at;

        $surat = ModelsSuratKeluar::create($validatedData);

        if ($surat) {
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Surat berhasil ditambahkan!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Surat gagal ditambahkan!"
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
        $this->dispatch('pondReset');
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

    public function testUpload()
    {
        dd($this->file);
    }

    public function updateSurat()
    {
        $validatedData = $this->validate();

        //detect the request->file with name 'file'
        $file = $this->file;

        $random = rand(1, 100000);

        if ($file) {
            //set file name with format $no_surat.$file->extension()
            $fileName = $random . '.' . $file->extension();

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
            //delete file
            if ($this->suratKeluar->file) {
                unlink(storage_path('app/public/docs/' . $this->suratKeluar->file));
            }
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
        if ($this->isEdit) {
            $this->isEdit = false;
        }
        $this->resetInputs();
    }

    public function sendReminder(ModelsSuratKeluar $suratKeluar)
    {
        return $this->dispatch('alert', [
            'type' => 'success',
            'message' => "Reminder berhasil dikirim!"
        ]);
    }
}
