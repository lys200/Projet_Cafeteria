<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plat;
use Illuminate\Support\Facades\DB;

class PlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plats = [
            [
                'code_plat' => 'P001',
                'nom_plat' => 'Poulet Grillée',
                'cuisson' => 'Grillé',
                'prix' => 250,
                'quantite' => 50,
                'image' => 'poulet_grille.jpg',
                'description' => 'Poulet mariné aux épices et grillé à perfection, servi avec du riz et des légumes frais.',
                'disponible_jour' => true
            ],
            [
                'code_plat' => 'P002',
                'nom_plat' => 'Salade César',
                'cuisson' => 'Cru',
                'prix' => 180,
                'quantite' => 30,
                'image' => 'salade_cesar.jpg',
                'description' => 'Salade fraîche avec laitue romaine, croûtons, parmesan et sa fameuse sauce césar.',
                'disponible_jour' => true
            ],
            [
                'code_plat' => 'P003',
                'nom_plat' => 'Steak Frites',
                'cuisson' => 'Cuit',
                'prix' => 320,
                'quantite' => 25,
                'image' => 'steak_frites.jpg',
                'description' => 'Steak juteux accompagné de frites croustillantes et d\'une sauce au choix.',
                'disponible_jour' => true
            ],
            [
                'code_plat' => 'P004',
                'nom_plat' => 'Poisson Braisé',
                'cuisson' => 'Grillé',
                'prix' => 280,
                'quantite' => 20,
                'image' => 'poisson_braise.jpg',
                'description' => 'Poisson frais braisé avec des épices, servi avec du riz et de la sauce tomate.',
                'disponible_jour' => true
            ],
            [
                'code_plat' => 'P005',
                'nom_plat' => 'Spaghetti Bolognaise',
                'cuisson' => 'Cuit',
                'prix' => 220,
                'quantite' => 40,
                'image' => 'spaghetti_bolognaise.jpg',
                'description' => 'Pâtes al dente avec une sauce bolognaise riche et savoureuse.',
                'disponible_jour' => true
            ],
            [
                'code_plat' => 'P006',
                'nom_plat' => 'Tacos',
                'cuisson' => 'Grillé',
                'prix' => 300,
                'quantite' => 35,
                'image' => 'tacos.jpg',
                'description' => 'Tortilla garnie de viande, fromage, légumes et sauce spéciale.',
                'disponible_jour' => true
            ],
            [
                'code_plat' => 'P007',
                'nom_plat' => 'Pizza Margherita',
                'cuisson' => 'Cuit',
                'prix' => 350,
                'quantite' => 15,
                'image' => 'pizza_margherita.jpg',
                'description' => 'Pizza traditionnelle avec sauce tomate, mozzarella et basilic frais.',
                'disponible_jour' => true
            ],
            [
                'code_plat' => 'P008',
                'nom_plat' => 'Hamburger Maison',
                'cuisson' => 'Grillé',
                'prix' => 280,
                'quantite' => 30,
                'image' => 'hamburger.jpg',
                'description' => 'Hamburger fait maison avec pain brioché, steak haché et garnitures fraîches.',
                'disponible_jour' => true
            ],
            [
                'code_plat' => 'P009',
                'nom_plat' => 'Riz Poulet Curry',
                'cuisson' => 'Cuit',
                'prix' => 240,
                'quantite' => 45,
                'image' => 'riz_curry.jpg',
                'description' => 'Riz parfumé au curry avec des morceaux de poulet tendres et des légumes.',
                'disponible_jour' => true
            ],
            [
                'code_plat' => 'P010',
                'nom_plat' => 'Lasagnes',
                'cuisson' => 'Cuit',
                'prix' => 320,
                'quantite' => 20,
                'image' => 'lasagnes.jpg',
                'description' => 'Couches de pâtes, sauce bolognaise, béchamel et fromage gratiné au four.',
                'disponible_jour' => true
            ]
        ];

        foreach ($plats as $plat) {
            Plat::create($plat);
        }
    
    }
}
