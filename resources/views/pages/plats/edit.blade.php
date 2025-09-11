@extends('pages.include.base')
@section('title')
Gestion Clients
@endsection
@section('titre_page')
Modifier le plat : {{ $plat->nom_plat }}
@endsection
@section('content')
    <form action="{{ route('plat.update', $plat->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nom Plat :</label>
        <input type="text" name="nom_plat" value="{{ old('nom_plat', $plat->nom_plat) }}" 
               required pattern="[A-Za-zÀ-ÿ\s]+" title="Seulement des lettres"><br><br>

        <label>Cuisson :</label>
        <select name="cuisson" required>
            <option value="Cru" {{ $plat->cuisson == 'Cru' ? 'selected' : '' }}>Cru</option>
            <option value="Cuit" {{ $plat->cuisson == 'Cuit' ? 'selected' : '' }}>Cuit</option>
            <option value="Grillé" {{ $plat->cuisson == 'Grillé' ? 'selected' : '' }}>Grillé</option>
        </select><br><br>

        <label>Prix :</label>
        <input type="number" name="prix" step="0.01" min="0.01" value="{{ old('prix', $plat->prix) }}" required><br><br>

        <label>Catégorie :</label>
        <select name="categorie" required>
            <option value="dejeuner" {{ $plat->categorie == 'dejeuner' ? 'selected' : '' }}>Déjeuner</option>
            <option value="diner" {{ $plat->categorie == 'diner' ? 'selected' : '' }}>Dîner</option>
            <option value="dessert" {{ $plat->categorie == 'dessert' ? 'selected' : '' }}>Dessert</option>
            <option value="boisson" {{ $plat->categorie == 'boisson' ? 'selected' : '' }}>Boisson</option>
            <option value="snack" {{ $plat->categorie == 'snack' ? 'selected' : '' }}>Snack</option>
        </select><br><br>

        <label>Quantité :</label>
        <input type="number" name="quantite" min="1" value="{{ old('quantite', $plat->quantite) }}" required><br><br>

        <label>Disponible aujourd'hui :</label>
        <input type="checkbox" name="disponible_jour" value="1" {{ $plat->disponible_jour ? 'checked' : '' }}><br><br>

        <label>Description :</label>
        <textarea name="description">{{ old('description', $plat->description) }}</textarea><br><br>

        <button type="submit">Mettre à jour</button>
    </form>

    <br>
    <a href="{{ route('plat.index') }}">⬅ Retour à la liste</a>
@endsection
