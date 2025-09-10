<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plat;

class PlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plats = Plat::where('disponible_jour', true) ->get();
        return view('pages.plats.index', compact('plats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.plats.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nom_plat' => 'required|regex:/^[A-Za-z\s]+$/',
        'cuisson' => 'required',
        'prix' => 'required|numeric',
        'quantite' => 'required|integer',
        
    ]);

   $plat = Plat::create([
       
        'nom_plat' => $request->nom_plat,
        'cuisson' => $request->cuisson,
        'prix' => $request->prix,
        'categorie' => $request->categorie,
        'quantite' => $request->quantite,
        'disponible_jour' => $request->has('disponible_jour'),
        'description' => $request->description,
    ]);

    return redirect()->route('plat.index')->with('alert', "Ajout du plat {$plat->code_plat} fait avec succès !");
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
    
        $plat = Plat::findOrFail($id);
        return view('pages.plats.edit', compact('plat'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $plat = Plat::findOrFail($id);

    $request->validate([
        
        'nom_plat' => 'required',
        'cuisson' => 'required',
        'prix' => 'required|numeric',
        'quantite' => 'required|integer',
    ]);

    $plat->update([
    
       'nom_plat' => $request->nom_plat,
        'cuisson' => $request->cuisson,
        'prix' => $request->prix,
        'categorie' => $request->categorie,
        'quantite' => $request->quantite,
        'disponible_jour' => $request->has('disponible_jour'),
        'description' => $request->description,
    ]);

    return redirect()->route('plat.index')->with('alert', "Modification du plat {$plat->code_plat} fait avec succès !");;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plat = Plat::findOrFail($id);
    $plat->delete();

    return redirect()->route('plat.index')->with('alert', "Suppression  du plat {$plat->code_plat} fait avec succès !");;
    }
}
