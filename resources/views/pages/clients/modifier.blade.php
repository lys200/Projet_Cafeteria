@extends('pages.include.base')
@section('title')
    Gestion Clients
@endsection
@section('titre_page')
    Formulaire de modification (CLient {{ $client->id }})
@endsection
{{-- @if ($errors->any())
<div style="color: red;">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif --}}
<!-- Messages flash -->
<div id="flash-messages">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
</div>
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