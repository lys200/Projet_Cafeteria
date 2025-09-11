
@extends('pages.include.base')
@section('title')
Gestion Clients
@endsection
@section('titre_page')
Formulaire de modification
@endsection
@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@section('content')

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
@endsection
