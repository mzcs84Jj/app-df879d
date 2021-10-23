<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    protected $table = "movimentacao";
    protected $fillable = [
        'sku',
        'qtd',
    ];

    public function produtos()
    {
        return $this->belongsTo(Produtos::class, 'sku');
    }    
}