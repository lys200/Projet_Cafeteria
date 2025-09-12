<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plat;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Plat::query();
        
        // Filtres
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nom_plat', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('categorie') && $request->categorie !== 'all') {
            $query->where('categorie', $request->categorie);
        }
        
        if ($request->has('disponible') && $request->disponible !== 'all') {
            $query->where('disponible_jour', $request->disponible);
        }
        
        // Tri
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'ancien':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'prix_asc':
                    $query->orderBy('prix', 'asc');
                    break;
                case 'prix_desc':
                    $query->orderBy('prix', 'desc');
                    break;
                case 'quantite_asc':
                    $query->orderBy('quantite', 'asc');
                    break;
                case 'quantite_desc':
                    $query->orderBy('quantite', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        $plats = $query->get();
        $categories = Plat::select('categorie')->distinct()->pluck('categorie');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('pages.plats.partials.plats-grid', compact('plats'))->render()
            ]);
        }

        return view('pages.plats.index', compact('plats', 'categories'));
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
        $validator = Validator::make($request->all(), [
            'nom_plat' => 'required|unique:plats,nom_plat|regex:/^[A-Za-zÀ-ÿ\s]+$/',
            'cuisson' => 'required|in:Cru,Cuit,Grillé',
            'prix' => 'required|numeric|min:0',
            'categorie' => 'required|in:dejeuner,diner,dessert,boisson,snack',
            'quantite' => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'nom_plat.unique' => 'Ce plat existe déjà. Veuillez le modifier plutôt que de créer un doublon.',
            'nom_plat.regex' => 'Le nom du plat ne doit contenir que des lettres et des espaces.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        // Gestion de l'upload d'image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Génération d'un nom unique avec extension
            $imageName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            
            // Stockage dans le dossier storage/images/plats
            $image->move(storage_path('app/public/images/plats'), $imageName);
            $data['image'] = $imageName;
        }

        // Génération du code plat automatique
        $data['code_plat'] = 'P' . strtoupper(substr($data['nom_plat'], 0, 3)) . date('His');

        $plat = Plat::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Plat créé avec succès.', 
                'plat' => $plat
            ]);
        }

        return redirect()->route('plats.index')->with('success', 'Plat créé avec succès.');
    }

    public function show(Plat $plat)
    {
        return response()->json($plat);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plat $plat)
    {
        return response()->json($plat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plat $plat)
    {
        $validator = Validator::make($request->all(), [
            'nom_plat' => 'required|unique:plats,nom_plat,' . $plat->id . '|regex:/^[A-Za-zÀ-ÿ\s]+$/',
            'cuisson' => 'required|in:Cru,Cuit,Grillé',
            'prix' => 'required|numeric|min:0',
            'categorie' => 'required|in:dejeuner,diner,dessert,boisson,snack',
            'quantite' => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'nom_plat.unique' => 'Ce nom de plat est déjà utilisé.',
            'nom_plat.regex' => 'Le nom du plat ne doit contenir que des lettres et des espaces.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Gestion de l'upload d'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($plat->image && file_exists(storage_path('app/public/images/plats/' . $plat->image))) {
                unlink(storage_path('app/public/images/plats/' . $plat->image));
            }

            $image = $request->file('image');
            // Génération d'un nom unique avec extension
            $imageName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            
            // Stockage dans le dossier storage/images/plats
            $image->move(storage_path('app/public/images/plats'), $imageName);
            $data['image'] = $imageName;
        }

        $plat->update($data);

        return response()->json([
            'success' => 'Plat mis à jour avec succès.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plat $plat)
    {
        // Supprimer l'image associée
        if ($plat->image && file_exists(storage_path('app/public/images/plats/' . $plat->image))) {
            unlink(storage_path('app/public/images/plats/' . $plat->image));
        }

        $plat->delete();
        
        return response()->json(['success' => 'Plat supprimé avec succès.']);
    }
}