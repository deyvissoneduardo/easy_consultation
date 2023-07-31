<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medico extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['nome', 'especilidade'];
    protected $dates = ['deleted_at'];

    public function cidades()
    {
        return $this->belongsTo(Cidades::class);
    }

    public function paciente()
    {
        return $this->belongsToMany(Paciente::class);
    }
}
