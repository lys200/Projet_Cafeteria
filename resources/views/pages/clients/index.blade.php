@extends('pages.include.base')
@section('title')
Gestion Clients
@endsection
@section('titre_page')
Gestion des Clients
@endsection

@section('content')

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
            @if(auth() -> user() -> role === 'admin')
                <th>Actions</th>
            @endif
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
            @if(auth()-> user() -> role === 'admin')
                <td>
                    <a href="{{route('client.edit', $client->id)}}">Modifier</a> ||
                    <form action="{{ route('client.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce client ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Supprimer</button>
                    </form>
                    {{-- <a href="{{ route('client.destroy', $client->id) }}"
                        onclick="return confirm('Voulez-vous vraiment supprimer ce client ?')">
                    Supprimer</a> --}}
                </td>
            @endif
        </tr>
        @endforeach

    </tbody>
   </table>
@endsection
