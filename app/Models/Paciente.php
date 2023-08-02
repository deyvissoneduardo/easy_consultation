<?php

namespace App\Models;

use App\Utils\ConstantTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = ConstantTable::TABLE_PATIENT;
    protected $fillable = ['nome', 'cpf', 'celular'];

    protected $dates = ['deleted_at'];

    public function doctor()
    {
        return $this->belongsToMany(Medico::class);
    }
}
