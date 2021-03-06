<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    protected $primaryKey = 'sku';
    public $incrementing = false;
    public $fillable = [
        'sku',
        'nome',
        'qtd',
    ];

    public function movimentacao()
    {
        return $this->hasMany(Movimentacao::class, 'sku');
    }        
}