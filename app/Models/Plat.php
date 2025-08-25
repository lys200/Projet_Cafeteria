<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Plat extends Model
{
     use HasFactory;

    protected $fillable = [
        'code_plat',
        'nom_plat',
        'cuisson',
        'prix',
        'quantite',
        'image',
        'description',
        'disponible_jour'
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'disponible_jour' => 'boolean'
    ];

      // Accessor pour l'image par défaut
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/images/plats/' . $this->image);
        }
        return asset('images/default-plat.jpg');
    }
}
