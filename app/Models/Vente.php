<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vente extends Model
{
   use HasFactory;

   protected $fillable = [
    'plat_id',
    'client_id',
    'code_vente',
    'nbre_plat',
    'montant_total',
    'date_vente'
   ];

   protected $casts =[
    'date_vente' => 'date',
    'montant_total' => 'decimal:2'
   ];

   public function client(){
       return $this->belongsTo(Client::class);
   }

   public function plat(){
    return $this->belongsTo(Plat::class);
   }

   /**
     * Génération automatique du username et code si absent
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($vente) {

            /**
             * Génération automatique du code_client
             */

            // Générer le code_client si vide
            if (empty($vente->code_vente)) {
                $id = str_pad((string)(Vente::max('id') + 1), 3, '0', STR_PAD_LEFT);
                $vente->code_vente = "Ve-" . $id;
            }
        });
    }


}
