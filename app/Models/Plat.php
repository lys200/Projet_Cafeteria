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
        'categorie',
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
    /**
     * Génération automatique du  code si absent
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($plat) {

            /**
             * Génération automatique du code_client
             */

            // Générer le code_client si vide
            if (empty($plat->code_plat)) {
                $id = str_pad((string)(Plat::max('id') + 1), 3, '0', STR_PAD_LEFT);
                $plat->code_plat = "Pl-" . $id;
            }
        });
    }
}
