<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Affichage </title>
</head>
<body>
    <a href="{{ route('client.create') }}">Ajouter un client</a>

   <table>
    <thead>
        <tr>
            <th>CodeClient</th>
            <th>Nom_Client</th>
            <th>Prenom_Client</th>
            <th>Email</th>
            <th>Type_Client</th>
            <th>Telephone</th>
            <th>Username</th>
            <th>Image</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clients as $client)
        <tr>
            <td>{{$client->code_client}}</td>
            <td>{{$client->nom_client}}</td>
            <td>{{$client->prenom_client}}</td>
            <td>{{$client->email}}</td>
            <td>{{$client->type_client}}</td>
            <td>{{$client->phone_client}}</td>
            <td>{{$client->username}}</td>
            <td>{{$client->image}}</td>
            <td>
                <a href="{{route('client.edit', $client->id)}}">Modifier</a> ||
               <a href="{{ route('client.destroy', $client->id) }}"
                    onclick="return confirm('Voulez-vous vraiment supprimer ce client ?')">
                Supprimer</a>
            </td>
        </tr>
        @endforeach

    </tbody>
   </table>
</body>
</html>
