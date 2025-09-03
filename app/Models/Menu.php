<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $connection = 'reportes';
    protected $table = 'menu';
    public $timestamps = false;

    protected $fillable = [
        'url',
        'opcion',
        'icono',
        'idmenupadre',
        'activo',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'idmenupadre');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'idmenupadre')->with('children');
    }
}

