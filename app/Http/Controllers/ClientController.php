<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        return view('pages.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.clients.ajouter');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // recuperation des names de l'input
       $validated = $request->validate([
        'nom' => 'required|string|min:3|max:255',
        'prenom' =>'required|string|min:3|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            'unique:clients,email',
            'regex:/^[\w\.\-]+@([\w\-]+\.)+[a-zA-Z]{2,6}$/'
        ],
        'type_client' => 'required|string',
        'tel' => 'required|string|min:8|max:15|unique:clients,phone_client',
        'username' => 'nullable|string|max:15|unique:clients',
        'image' => 'nullable|string',
       ],

        ['nom.min' => 'Le nom doit contenir au moins 3 lettres',
          'prenom.min'  => 'le prenom doit avoir au moins 3 lettres',
          'email.email' => "L'adresse email n'est pas valide",
          'email.unique' => "Cet email existe déja",
          'tel.required' => "Le numéro de téléphone est obligatoire",
          'tel.min' => "Le numéro de téléphone doit contenir au moins 8 chiffres",
          'tel.max' => "Le numéro de téléphone ne peut pas dépasser 15 chiffres",
          'tel.unique' => "Ce numéro de téléphone existe déjà",
          'username.unique' => "Ce nom d'utilisateur existe déjà",
        ]);


        // Mapping vers les colonnes de la DB
        $data = [
            'nom_client'     => $validated['nom'],
            'prenom_client'  => $validated['prenom'],
            'email'          => $validated['email'],
            'type_client'    => $validated['type_client'],
            'phone_client'   => $validated['tel'],
            'username'       => $validated['username']??null,
            'image'          => $validated['image'] ?? null,
        ];

        // Enregistrement
        Client::create($data);
        //    redirection vers index avec message
        return redirect()->route('client.index') ->with('success', "Client enregistré avec succès.");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // dans le chiffier modifier.blade.php j'ai $client
        $client = Client::findOrFail($id);
        return view('pages.clients.modifier', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            // recuperation des names de l'input
       $validated = $request->validate([
        'nom' => 'required|string|min:3|max:255',
        'prenom' =>'required|string|min:3|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            'unique:clients,email',
            'regex:/^[\w\.\-]+@([\w\-]+\.)+[a-zA-Z]{2,6}$/'
        ],
        'tel' => 'required|string|max:15|unique:clients,phone_client,' . $id,
    ],

        [
          'nom.min' => 'Le nom doit contenir au moins 3 lettres',
          'prenom.min'  => 'le prenom doit avoir au moins 3 lettres',
          'email.email' => "L'adresse email n'est pas valide",
          'email.unique' => "Cet email existe déja",
          'tel.required' => "Le numéro de téléphone est obligatoire",
          'tel.min' => "Le numéro de téléphone doit contenir au moins 8 chiffres",
          'tel.max' => "Le numéro de téléphone ne peut pas dépasser 15 chiffres",
          'tel.unique' => "Ce numéro de téléphone existe déjà",


       ]);


       $client = Client::findOrFail($id);
        // rediriger vers les colonnes de la DB
        $data = [
            'nom_client'     => $validated['nom'],
            'prenom_client'  => $validated['prenom'],
            'email'          => $validated['email'],
            'phone_client'   => $validated['tel'],
        ];

        // modifer
        $client->update($data);
        //    redirection vers index avec message
        return redirect()->route('client.index') ->with('success', "Client modifié avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('client.index')->with('success', 'Client supprimé avec succès');

    }
}
