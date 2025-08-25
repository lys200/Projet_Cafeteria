<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_client',
        'nom_client',
        'prenom_client',
        'email',
        'type_client',
        'phone_client',
        'image',
        'username',
        'image',
    ];

// Accessor pour l'image par défaut
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/images/clients/' . $this->image);
        }
        return asset('images/default-avatar.png');
    }
    public function vente()
    {
        return $this->hasMany(Vente::class);
    }
}
