@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier les informations du client</title>
</head>
<body>
    <h1>Formulaire de modification</h1>
    <form action="{{route('client.update', $client->id)}}" method="post">
        @csrf
        @method('put')
        {{-- champ de saisie --}}
        <div>
            <label for="nom">Nom Clients</label>
            <input type="text" name="nom" value="{{old('nom', $client->nom_client)}}" required>
        </div><br>
         <div>
            <label for="prenom">Prenom Clients</label>
            <input type="text" name="prenom" value="{{old('prenom', $client->prenom_client)}}" required>
        </div><br>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" value="{{old('email', $client->email)}}" required>
        </div><br>
        <div>
            <label for="tel">Telephone</label>
            <input type="text" name="tel" value="{{old('tel', $client->phone_client)}}" required>
        </div><br>
        <div>
            <button type="submit"> ModifierClient </button>
        </div><br>
</body>
</html>
