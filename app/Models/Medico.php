<?php

namespace App\Models;

use App\Utils\ConstantTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medico extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = ConstantTable::TABLE_DOCTOR;
    protected $fillable = ['nome', 'especilidade'];
    protected $dates = ['deleted_at'];

    public function cities()
    {
        return $this->belongsTo(Cidades::class);
    }

    public function patient()
    {
        return $this->belongsToMany(Paciente::class);
    }
}
