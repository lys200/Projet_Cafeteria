<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Plat</title>
</head>
<body>
    <h1>Liste des plats</h1>
    <a href="{{route('plat.create')}}">ajouter un plat</a>

    <table>
        <thead>

            <tr>
            <th>Code_plat</th>
            <th>Nom_Plat</th>
            <th>Cuisson</th>
            <th>Prix</th>
            <th>Quantité </th>
            <th>Disponible_jour</th>
            <th>Description</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($plats as $plat)
            <tr>
                <td>{{$plat->code_plat}}</td>
                <td>{{$plat->nom_plat}}</td>
                <td>{{$plat->cuisson}}</td>
                <td>{{$plat->prix}}</td>
                <td>{{$plat->quantite}}</td>
                <td>{{$plat->disponible_jour}}</td>
                <td>{{$plat->description}}</td>
                <td>
                    <a href="{{route('plat.edit', $plat->id)}}">Modifier</a> ||
                    <a href="{{route('plat.destroy', $plat->id)}}">Supprimer</a>

                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>

