<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'letters';

    protected $fillable = [
        'id',
        'type',
        'no_surat',
        'tujuan',
        'uraian',
        'id_user',
        'file',
        'status',
    ];
}
