<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidades extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'estado'];

    public function medico()
    {
        return $this->hasMany(Medico::class);
    }
}
