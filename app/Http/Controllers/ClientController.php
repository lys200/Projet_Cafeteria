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
        'nom' => 'required|string|max:255',
        'prenom' =>'required|string|max:255',
        'email' => 'required|string|unique:clients',
        'type_client' => 'required|string',
        'tel' => 'required|numeric',
        'username' => 'required|string|max:15|unique:clients',
        'image' => 'required|string',
       ]);


        // Mapping vers les colonnes de la DB
        $data = [
            'nom_client'     => $validated['nom'],
            'prenom_client'  => $validated['prenom'],
            'email'          => $validated['email'],
            'type_client'    => $validated['type_client'],
            'phone_client'   => $validated['tel'],
            'username'       => $validated['username'],
            'image'          => $validated['image'] ?? null,
        ];

        // Enregistrement
        Client::create($data);
        //    redirection vers index avec message
        return redirect()->route('client.index') ->with('succes', "Client enregistré avec succès.");
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
        'nom' => 'required|string|max:255',
        'prenom' =>'required|string|max:255',
        'tel' => 'required|string|max:25|unique:clients,phone_client,' . $id,
       ]);


       $client = Client::findOrFail($id);
        // rediriger vers les colonnes de la DB
        $data = [
            'nom_client'     => $validated['nom'],
            'prenom_client'  => $validated['prenom'],
            'phone_client'   => $validated['tel'],
        ];

        // modifer
        $client->update($data);
        //    redirection vers index avec message
        return redirect()->route('client.index') ->with('succes', "Client modifié avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('client.index')->with('succes', 'Client supprimé avec succès');

    }
}
