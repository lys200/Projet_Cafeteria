@extends('pages.include.base')
@section('title')
Gestion Plats
@endsection
@section('titre_page')
Ajouter un plat
@endsection
    
@section('content')


    <form action="{{ route('plat.store') }}" method="POST"    enctype="multipart/form-data">
        @csrf

        <label>Nom Plat :</label>
        <input type="text" name="nom_plat" value="{{ old('nom_plat') }}" 
               required pattern="[A-Za-zÀ-ÿ\s]+" title="Seulement des lettres"><br><br>

      <label>Image :</label>
    <input type="file" name="image" accept="image/*"><br>

        <label>Cuisson :</label>
        <select name="cuisson" required>
            <option value="Cru">Cru</option>
            <option value="Cuit">Cuit</option>
            <option value="Grillé">Grillé</option>
        </select><br><br>

        <label>Prix :</label>
        <input type="number" name="prix" step="0.01" min="0.01" required><br><br>

        <label>Catégorie :</label>
        <select name="categorie" required>
            <option value="dejeuner">Déjeuner</option>
            <option value="diner">Dîner</option>
            <option value="dessert">Dessert</option>
            <option value="boisson">Boisson</option>
            <option value="snack">Snack</option>
        </select><br><br>

        <label>Quantité :</label>
        <input type="number" name="quantite" min="1" required><br><br>

        <label>Disponible aujourd'hui :</label>
        <input type="checkbox" name="disponible_jour" value="1"><br><br>

        <label>Description :</label>
        <textarea name="description">{{ old('description') }}</textarea><br><br>


        <button type="submit">Enregistrer</button>
    </form>

    <br>
    <a href="{{ route('plat.index') }}">⬅ Retour à la liste </a>
@endsection
