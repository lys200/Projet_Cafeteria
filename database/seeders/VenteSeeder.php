<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vente;
use App\Models\Client;
use App\Models\Plat;

class VenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //recuperation des clients et plats

        $clients = Client::all();
        $plats =Plat::all();

        // creer ventes avec des donnees laravel
        for($i = 0; $i < 10; $i++){
           $client = $clients->random();
            $plat = $plats->random();

             //verifier si le client a deja effectue une vente
            $venteExistante = Vente::where('client_id', $client->id)
            ->whereDate('date_vente', today())
            ->exists();

            if(!$venteExistante){
                $nbrePlat = 1;
                $montantTotal = $plat->prix;

                Vente::create([
                    'client_id' => $client->id,
                    'plat_id' => $plat->id,
                    // 'code_vente' => $vente->code_vente,
                    'nbre_plat' => $nbrePlat,
                    'montant_total' => $montantTotal,
                    'date_vente' => today()
                ]);
            }
        }

        //creer qques ventes pour les jours precedents
       for($i = 0; $i < 5; $i++){
           $client = $clients->random();
            $plat = $plats->random();

             //verifier si le client a deja effectue une vente
            $venteExistante = Vente::where('client_id', $client->id)
            ->whereDate('date_vente', today())
            ->exists();

            if(!$venteExistante){
                $nbrePlat = 1;
                $montantTotal = $plat->prix;

                Vente::create([
                    'client_id' => $client->id,
                    'plat_id' => $plat->id,
                    // 'code_vente' => $code_vente,
                    'nbre_plat' => $nbrePlat,
                    'montant_total' => $montantTotal,
                    'date_vente' => today()->subDays($i)
                ]);
            }
        }

    }
}
