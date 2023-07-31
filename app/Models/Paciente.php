<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'paciente';
    protected $fillable = ['nome', 'cpf', 'celular'];

    protected $dates = ['deleted_at'];

    public function medico()
    {
        return $this->belongsToMany(Medico::class);
    }
}
