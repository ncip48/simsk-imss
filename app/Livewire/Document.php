<?php

namespace App\Livewire;

use App\Models\Document as ModelsDocument;
use App\Models\Signature;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use setasign\Fpdi\Tcpdf\Fpdi;

class Document extends Component
{
    use WithPagination, WithFileUploads;

    public $user_id, $signature_id, $title, $file, $file_signed, $signatures = [], $document = null, $isView = false, $isEdit = false;

    public function render()
    {
        $documents = ModelsDocument::where('user_id', auth()->user()->id)->paginate(10);
        $this->signatures = Signature::where('user_id', auth()->user()->id)->get();
        return view('livewire.dokumen.index', [
            'documents' => $documents
        ]);
    }

    protected $rules = [
        'title' => 'required',
        'signature_id' => 'required',
        'file' => 'required|mimes:pdf',
    ];

    protected $messages = [
        'title.required' => 'Judul tidak boleh kosong.',
        'signature_id.required' => 'Tanda tangan tidak boleh kosong.',
        'file.required' => 'File tidak boleh kosong.',
        'file.mimes' => 'File harus berupa pdf.',
    ];

    public function saveDocument()
    {

        $this->validate();

        $files = $this->file;

        //save to storage/app/public/temp
        $random_name = uniqid() . '_' . time();
        $files->storeAs('public/temp', $random_name . '.' . $files->getClientOriginalExtension());

        //get the path full path of the file
        $path = $files->path();

        $certificate = Signature::where('id', $this->signature_id)->first();

        // Load your private keys and certificates for each signer
        $signer1PrivateKey = $certificate->private_key;
        $signer1Certificate = $certificate->certificate;

        $pdf = new Fpdi();
        $pdf->AddPage();

        //import from $files
        $pageCount = $pdf->setSourceFile($path);

        //iterate through all pages
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $tplIdx = $pdf->importPage($pageNo);
            $pdf->useTemplate($tplIdx);
            if ($pageNo < $pageCount) {
                $pdf->AddPage();
            }
        }

        $info = array(
            'Name' => 'Herly Chahya Putra',
        );

        $pdf->setSignature($signer1Certificate, $signer1PrivateKey, 'kocak123', '', 2, $info, 'A');

        $qr = storage_path('app/public/qr/' . $certificate->signature . '.png');

        $pdf->Image($qr, 150, 50, 30, 30, 'PNG');
        $pdf->setSignatureAppearance(150, 50, 30, 30);

        // $pdf->Output('multi_signed_file.pdf', 'I');

        //save the pdf to storage/app/public/signed
        $pdf->Output(storage_path('app/public/signed') . '/' . $certificate->signature . '_sign.pdf', 'F');

        //save to database
        ModelsDocument::create([
            'user_id' => auth()->user()->id,
            'signature_id' => $this->signature_id,
            'title' => $this->title,
            'file' => $random_name . '.' . $files->getClientOriginalExtension(),
            'file_signed' => $certificate->signature . '_sign.pdf',
        ]);

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => "Dokumen berhasil ditandatangani!"
        ]);

        $this->resetInputs();

        $this->dispatch('close-modal');
    }

    public function verifyDocument()
    {
        return $this->dispatch('alert', [
            'type' => 'info',
            'message' => "Fitur masih dalam tahap pengembangan, see u~"
        ]);
    }

    public function resetInputs()
    {
        $this->user_id = null;
        $this->signature_id = null;
        $this->title = null;
        $this->file = null;
        $this->file_signed = null;
    }

    public function deleteDocument(ModelsDocument $document)
    {
        $this->document = $document;
    }

    public function destroyDocument()
    {
        if ($this->document) {
            //unlink in temp and signed
            unlink(storage_path('app/public/temp') . '/' . $this->document->file);
            unlink(storage_path('app/public/signed') . '/' . $this->document->file_signed);
            $this->document->delete();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Dokumen berhasil dihapus!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Dokumen gagal dihapus!"
            ]);
        }

        $this->dispatch('close-modal');
    }

    public function closeModal()
    {
        $this->resetInputs();
    }
}
