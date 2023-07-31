<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'especilidade'];

    public function cidades()
    {
        return $this->belongsTo(Cidades::class);
    }
}
