<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $clients = [
            [
                'code_client' => 'C001',
                'nom_client' => 'Jean',
                'prenom_client' => 'Dupont',
                'email' => 'JeanDupont@gmail.com',
                'type_client' => 'étudiant',
                'phone_client' => '3610-1234',
                'image' => 'etudiant1.jpg'
            ],
            [
                'code_client' => 'C002',
                'nom_client' => 'Marie',
                'prenom_client' => 'Laurent',
                'email' => 'MarieDupon@gmail.com',
                'type_client' => 'étudiant',
                'phone_client' => '3610-5678',
                'image' => 'etudiante2.jpg'
            ],
            [
                'code_client' => 'C003',
                'nom_client' => 'Pierre',
                'prenom_client' => 'Michel',
                'email' => 'pierremichel@gmail.com',
                'type_client' => 'professeur',
                'phone_client' => '3610-9012',
                'image' => 'prof1.jpg'
            ],
            [
                'code_client' => 'C004',
                'nom_client' => 'Sophie',
                'prenom_client' => 'Martin',
                'email' => 'sophiemartin@gmail.com',
                'type_client' => 'professeur',
                'phone_client' => '3610-3456',
                'image' => 'prof2.jpg'
            ],
            [
                'code_client' => 'C005',
                'nom_client' => 'Marc',
                'prenom_client' => 'Antoine',
                'email' => 'marcantoine@gmail.com',
                'type_client' => 'personnel admin',
                'phone_client' => '3610-7890',
                'image' => 'admin1.jpg'
            ],
            [
                'code_client' => 'C006',
                'nom_client' => 'Lucie',
                'prenom_client' => 'Bernard',
                'email' => 'luciebernard@gmail.com',
                'type_client' => 'personnel admin',
                'phone_client' => '3610-2345',
                'image' => 'admin2.jpg'
            ],
            [
                'code_client' => 'C007',
                'nom_client' => 'Thomas',
                'prenom_client' => 'Legrand',
                'email' => 'thomaslegend@gmail.com',
                'type_client' => 'invite',
                'phone_client' => '3610-6789',
                'image' => 'invite1.jpg'
            ],
            [
                'code_client' => 'C008',
                'nom_client' => 'Nathalie',
                'prenom_client' => 'Petit',
                'type_client' => 'invite',
                'email' => 'nathaliepetie@gmail.com',
                'phone_client' => '3610-0123',
                'image' => 'invite2.jpg'
            ],
            [
                'code_client' => 'C009',
                'nom_client' => 'David',
                'prenom_client' => 'Moreau',
                'email' => 'davidmoreau@gmail.com',
                'type_client' => 'étudiant',
                'phone_client' => '3610-4567',
                'image' => 'etudiant3.jpg'
            ],
            [
                'code_client' => 'C010',
                'nom_client' => 'Dr. Claire',
                'prenom_client' => 'Dubois',
                'email' => 'clairedubois@gmail.com',
                'type_client' => 'professeur',
                'phone_client' => '3610-8901',
                'image' => 'prof3.jpg'
            ]
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
