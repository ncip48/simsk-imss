<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $primaryKey = 'id_divisi';

    protected $fillable = [
        'nama',
        'kode',
    ];
}
