<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $table = "buku" ;     //untuk menentukan nama tabelnya 
    protected $fillable = ['judul', 'pengarang' , 'tanggal_publikasi'] ; 
}
