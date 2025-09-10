
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des plats</title>
</head>
<body>
    <h1>Liste des plats</h1>

    <a href="{{ route('plat.create') }}">Ajouter un plat</a>

    @if(session('success'))
        <script>alert("{{ session('success') }}");</script>
    @endif

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                 <th>Code_Plat</th>
                <th>Nom_Plat</th>
                <th>Cuisson</th>
                <th>Prix</th>
                <th>Categorie</th>
                <th>Quantité</th>
                <th>Disponible_jour</th>
                <th>Description</th>
                <th>Date_enre</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($plats as $plat)
            <tr>
                <td>{{ $plat->code_plat }}</td>
                <td>{{ $plat->nom_plat }}</td>
                <td>{{ $plat->cuisson }}</td>
                <td>{{ $plat->prix }} $</td>
                <td>{{ $plat->categorie }}</td>
                <td>{{ $plat->quantite }}</td>
                <td>{{ $plat->disponible_jour ? 'Oui' : 'Non' }}</td>
                <td>{{ $plat->description }}</td>
                <td>{{ $plat->create_at }}</td>
                <td>
                    <a href="{{route('plat.edit', $plat->id)}}">Modifier</a> ||
            
<form action="{{ route('plat.destroy', $plat->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Voulez-vous vraiment supprimer ce plat ?')">
        @csrf
        @method('DELETE')
        <button type="submit">Supprimer</button>
    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>


