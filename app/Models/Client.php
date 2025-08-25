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
    ];
    /**
     * Génération automatique du username et code si absent
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($client) {
            if (empty($client->username)) {
                $nom = ucfirst(substr($client->nom_client, 0, 3));       // 3 premières lettres du nom
                $prenom = ucfirst(substr($client->prenom_client, 0, 3)); // 3 premières lettres du prénom
                $id = str_pad((string)(Client::max('id') + 1), 3, '0', STR_PAD_LEFT); // ex: 001, 002...

                $client->username = $nom . $prenom . $id;
            }


            /**
             * Génération automatique du code_client
             */


            // Générer le code_client si vide
            if (empty($client->code_client)) {
                $id = str_pad((string)(Client::max('id') + 1), 3, '0', STR_PAD_LEFT);
                $client->code_client = "Cl-" . $id;
            }
        });
    }

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
