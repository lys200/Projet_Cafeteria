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

   
}
