<?php

namespace App\Models;

use App\Utils\ConstantTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cidades extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = ConstantTable::TABLE_CITY;
    protected $fillable = ['nome', 'estado'];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'deleted_at',
        'updated_at,'
    ];


    public function doctor()
    {
        return $this->hasMany(Medico::class);
    }
}
