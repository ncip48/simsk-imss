<?php

namespace App\Livewire;

use App\Models\Signature as ModelsSignature;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use PDO;
use setasign\Fpdi\Tcpdf\Fpdi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Signature extends Component
{
    public $user_id, $sign, $file, $private_key, $certificate, $issuer, $signature = null, $isView = false, $isEdit = false;

    public function render()
    {
        $signatures = ModelsSignature::where('user_id', auth()->user()->id)->paginate(10);
        //concat the qr in this function to show in view
        foreach ($signatures as $signature) {
            $this->generateQR($signature->signature);
            $signature->qr = asset('storage/qr/' . $signature->signature . '.png');
        }
        return view('livewire.tanda-tangan.index', [
            'signatures' => $signatures
        ]);
    }

    public function generateCertificate(string $name)
    {
        // Generate a new CA key pair
        $caConfig = array(
            "digest_alg" => "sha256",
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );

        $caPrivateKey = openssl_pkey_new($caConfig);
        openssl_pkey_export($caPrivateKey, $caPrivateKeyPEM, 'kocak123');

        $caDN = array(
            "countryName" => "ID",
            "stateOrProvinceName" => "Jawa Timur",
            "localityName" => "Ngawi",
            "organizationName" => "Dotech Digital",
            "commonName" => "Dotech Digital CA",
        );

        // Generate a self-signed CA certificate
        $caCertificate = openssl_csr_sign(openssl_csr_new($caDN, $caPrivateKey, $caConfig), null, $caPrivateKey, 365, $caConfig);
        openssl_x509_export($caCertificate, $caCertificatePEM);

        // Generate a new certificate signing request (CSR) for the end entity
        $entityDN = array(
            "countryName" => "ID",
            "stateOrProvinceName" => "Jawa Timur",
            "localityName" => "Madiun",
            "organizationName" => "PT. IMSS",
            "commonName" => $name,
        );

        $entityPrivateKey = openssl_pkey_new($caConfig);
        openssl_pkey_export($entityPrivateKey, $entityPrivateKeyPEM, 'kocak123');

        $csr = openssl_csr_new($entityDN, $entityPrivateKey, $caConfig);
        openssl_csr_export($csr, $csrPEM);

        // Issue a certificate from the CA for the end entity
        $entityCertificate = openssl_csr_sign($csr, $caCertificate, $caPrivateKey, 365, $caConfig);
        openssl_x509_export($entityCertificate, $entityCertificatePEM);

        //random string for signature to show qr code
        $randomString = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10 / strlen($x)))), 1, 10);

        $result = new \stdClass();
        $result->private_key = $entityPrivateKeyPEM;
        $result->certificate = $entityCertificatePEM;
        $result->signature = $randomString;

        $this->private_key = $entityPrivateKeyPEM;
        $this->certificate = $entityCertificatePEM;
        $this->sign = $randomString;
    }

    public static function generateQR($string)
    {
        $qr =  QrCode::format('png')
            ->size('512')
            ->margin(1)
            ->generate(
                $string
            );

        //save to storage
        return Storage::put('public/qr/' . $string . '.png', $qr);
    }

    public function signDocument()
    {
        $file = $this->file;

        dd($file);
    }

    public function generateSignature()
    {
        $files = storage_path('app/public/docs/signed.pdf');

        $certificate = ModelsSignature::first()->latest()->first();

        // Load your private keys and certificates for each signer
        $signer1PrivateKey = $certificate->private_key;
        $signer1Certificate = $certificate->certificate;

        $pdf = new Fpdi();
        $pdf->AddPage();

        //import from $files
        $pageCount = $pdf->setSourceFile($files);

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

        //read signature from signature tables
        $signature = ModelsSignature::first()->latest()->first();

        $qr = storage_path('app/public/qr/' . $signature->signature . '.png');

        $pdf->Image($qr, 150, 50, 30, 30, 'PNG');
        $pdf->setSignatureAppearance(150, 50, 30, 30);

        $pdf->Output('multi_signed_file.pdf', 'I');
    }

    public function checkSignature()
    {
        $pdfFileName = 'signed.pdf';
        $pdfFilePath = storage_path('app/public/' . $pdfFileName);

        if (!file_exists($pdfFilePath)) {
            die("Error: The PDF file does not exist.");
        }

        // Load the PDF document
        $pdfContent = Storage::get('public/' . $pdfFileName);

        // dd($pdfContent);

        if (empty($pdfContent)) {
            die("Error: The PDF file is empty or could not be read.");
        }

        if (!preg_match('%PDF-1.%', $pdfContent)) {
            die("Error: The loaded content is not a valid PDF.");
        }

        // $pdfContent = str_replace(chr(0), '', $pdfContent);

        $certificate = ModelsSignature::all();

        // Load the signatures (you'll need to adapt this to your database structure)
        $signatures = [
            [
                'certificate' => $certificate[0]->certificate,
                'name' => $certificate[0]->issuer
            ]
        ];

        foreach ($signatures as $signature) {
            $certificatePath = $signature['certificate'];
            $name = $signature['name'];

            // Verify the signature
            $result = openssl_pkcs7_verify($pdfContent, PKCS7_NOVERIFY, $certificatePath, [], '', '', $name);

            if ($result === 1) {
                echo "Signature for $name is valid.<br>";
            } elseif ($result === 0) {
                echo "Signature for $name is invalid.<br>";
            } else {
                echo "Error verifying signature for $name.<br>";
            }
        }
    }

    protected $rules = [
        'issuer' => 'required'
    ];

    protected $messages = [
        'issuer.required' => 'Issuer (Nama TTD) tidak boleh kosong.'
    ];

    public function storeSignature()
    {
        $validatedData = $this->validate();


        $validatedData['user_id'] = auth()->user()->id;
        $this->generateCertificate($this->issuer);

        $validatedData['private_key'] = $this->private_key;
        $validatedData['certificate'] = $this->certificate;
        $validatedData['signature'] = $this->sign;

        $user = ModelsSignature::create($validatedData);

        $this->generateQR($validatedData['signature']);

        if ($user) {
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Tanda tangan berhasil ditambahkan!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Tanda tangan gagal ditambahkan!"
            ]);
        }

        $this->resetInputs();

        $this->dispatch('close-modal');
    }

    public function saveSignature()
    {
        if (!$this->isEdit) {
            $this->storeSignature();
        }
    }

    public function resetInputs()
    {
        $this->user_id = null;
        $this->sign = null;
        $this->issuer = null;
        $this->signature = null;
    }

    public function deleteSignature(ModelsSignature $signature)
    {
        $this->signature = $signature;
    }

    public function destroySignature()
    {
        if ($this->signature) {
            //unlink in storage/qr
            Storage::delete('public/qr/' . $this->signature->signature . '.png');
            $this->signature->delete();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Tanda tangan berhasil dihapus!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Tanda tangan gagal dihapus!"
            ]);
        }

        $this->dispatch('close-modal');
    }

    public function closeModal()
    {
        $this->resetInputs();
    }
}
