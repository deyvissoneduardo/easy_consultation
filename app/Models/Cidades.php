<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cidades extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'cidades';
    protected $fillable = ['nome', 'estado'];

    protected $dates = ['deleted_at'];

    public function medico()
    {
        return $this->hasMany(Medico::class);
    }
}
