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
                'nom_client' => 'Jean Dupont',
                'type_client' => 'étudiant',
                'phone_client' => '3610-1234',
                'image' => 'etudiant1.jpg'
            ],
            [
                'code_client' => 'C002',
                'nom_client' => 'Marie Laurent',
                'type_client' => 'étudiant',
                'phone_client' => '3610-5678',
                'image' => 'etudiante2.jpg'
            ],
            [
                'code_client' => 'C003',
                'nom_client' => 'Dr. Pierre Michel',
                'type_client' => 'professeur',
                'phone_client' => '3610-9012',
                'image' => 'prof1.jpg'
            ],
            [
                'code_client' => 'C004',
                'nom_client' => 'Prof. Sophie Martin',
                'type_client' => 'professeur',
                'phone_client' => '3610-3456',
                'image' => 'prof2.jpg'
            ],
            [
                'code_client' => 'C005',
                'nom_client' => 'Marc Antoine',
                'type_client' => 'personnel admin',
                'phone_client' => '3610-7890',
                'image' => 'admin1.jpg'
            ],
            [
                'code_client' => 'C006',
                'nom_client' => 'Lucie Bernard',
                'type_client' => 'personnel admin',
                'phone_client' => '3610-2345',
                'image' => 'admin2.jpg'
            ],
            [
                'code_client' => 'C007',
                'nom_client' => 'Thomas Legrand',
                'type_client' => 'invite',
                'phone_client' => '3610-6789',
                'image' => 'invite1.jpg'
            ],
            [
                'code_client' => 'C008',
                'nom_client' => 'Nathalie Petit',
                'type_client' => 'invite',
                'phone_client' => '3610-0123',
                'image' => 'invite2.jpg'
            ],
            [
                'code_client' => 'C009',
                'nom_client' => 'David Moreau',
                'type_client' => 'étudiant',
                'phone_client' => '3610-4567',
                'image' => 'etudiant3.jpg'
            ],
            [
                'code_client' => 'C010',
                'nom_client' => 'Dr. Claire Dubois',
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
