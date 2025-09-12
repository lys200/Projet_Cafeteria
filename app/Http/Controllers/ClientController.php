<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Client::query();

        // Filtres
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('nom_client', 'like', '%' . $request->search . '%')
                    ->orWhere('prenom_client', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone_client', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('type_client') && $request->type_client !== 'all') {
            $query->where('type_client', $request->type_client);
        }

        // Tri
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'nom_asc':
                    $query->orderBy('nom_client', 'asc');
                    break;
                case 'nom_desc':
                    $query->orderBy('nom_client', 'desc');
                    break;
                case 'recent':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'ancien':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $clients = $query->get();
        $typesClient = Client::select('type_client')->distinct()->pluck('type_client');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('pages.clients.partials.clients-table', compact('clients'))->render()
            ]);
        }

        return view('pages.clients.index', compact('clients', 'typesClient'));
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
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|min:3|max:255',
            'prenom' => 'required|string|min:3|max:255',
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
        ], [
            'nom.min' => 'Le nom doit contenir au moins 3 lettres',
            'prenom.min' => 'le prenom doit avoir au moins 3 lettres',
            'email.email' => "L'adresse email n'est pas valide",
            'email.unique' => "Cet email existe déja",
            'tel.required' => "Le numéro de téléphone est obligatoire",
            'tel.min' => "Le numéro de téléphone doit contenir au moins 8 chiffres",
            'tel.max' => "Le numéro de téléphone ne peut pas dépasser 15 chiffres",
            'tel.unique' => "Ce numéro de téléphone existe déjà",
            'username.unique' => "Ce nom d'utilisateur existe déjà",
        ]);

        // Génération du code client
        $codeClient = 'CL' . strtoupper(substr($validated['nom'], 0, 3)) . date('His');

        // Mapping vers les colonnes de la DB
        $data = [
            'nom_client' => $validated['nom'],
            'prenom_client' => $validated['prenom'],
            'email' => $validated['email'],
            'type_client' => $validated['type_client'],
            'phone_client' => $validated['tel'],
            'username' => $validated['username'] ?? null,
            'image' => $validated['image'] ?? null,
            'code_client' => $codeClient,
        ];

        // Enregistrement
        Client::create($data);

        // Redirection vers index avec message
        return redirect()->route('client.index')->with('success', "Client enregistré avec succès.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return response()->json($client);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return response()->json($client);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        // Validation des données
        $validated = $request->validate([
            'nom_client' => 'required|string|min:3|max:255',
            'prenom_client' => 'required|string|min:3|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:clients,email,' . $client->id,
                'regex:/^[\w\.\-]+@([\w\-]+\.)+[a-zA-Z]{2,6}$/'
            ],
            'phone_client' => 'required|string|min:8|max:15|unique:clients,phone_client,' . $client->id,
            'type_client' => 'required|string|in:etudiant,professeur,personnel_admin,invite',
        ], [
            'nom_client.min' => 'Le nom doit contenir au moins 3 lettres',
            'prenom_client.min' => 'le prenom doit avoir au moins 3 lettres',
            'email.email' => "L'adresse email n'est pas valide",
            'email.unique' => "Cet email existe déja",
            'phone_client.required' => "Le numéro de téléphone est obligatoire",
            'phone_client.min' => "Le numéro de téléphone doit contenir au moins 8 chiffres",
            'phone_client.max' => "Le numéro de téléphone ne peut pas dépasser 15 chiffres",
            'phone_client.unique' => "Ce numéro de téléphone existe déjà",
            'type_client.in' => "Le type de client sélectionné n'est pas valide",
        ]);

        // Mise à jour
        $client->update($validated);

        return response()->json(['success' => 'Client modifié avec succès.']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json(['success' => 'Client supprimé avec succès.']);
    }
}