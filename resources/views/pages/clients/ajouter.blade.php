@extends('pages.include.base')
@section('title')
Gestion Clients
@endsection
@section('titre_page')
Formulaire de Saisie de Clients
@endsection
@if (session('success'))
    <div>
        {{session('success')}}
    </div>

@endif
@section('content')

    {{-- formulaire de saisie des infos sur le client  --}}
    <form action="{{route('client.store')}}" method="post">
        @csrf
        <div>
            <label for="nom">Nom Clients</label>
            <input type="text" name="nom" value="{{old('nom')}}" placeholder="Entrez le nom" required>
            @error('nom')
                <span>{{$message}}</span>
            @enderror
        </div><br>
         <div>
            <label for="prenom">Prenom Clients</label>
            <input type="text" name="prenom" value="{{old('prenom')}}" placeholder="Entrez le prenom" required>
            @error('prenom')
                <span>{{$message}}</span>
            @enderror
        </div><br>
         <div>
            <label for="email">Email</label>
            <input type="email" name="email" value="{{old('email')}}" placeholder="Entrez l'email" required>
            @error('email')
                <span>{{$message}}</span>
            @enderror
        </div><br>
          <div>
           {{-- type client --}}
             <label for="type_client">Type de Client</label>
           <select name="type_client" required>
                <option value="">-- Selectionnez une option--</option>
                <option value="etudiant">Etudiant</option>
                <option value="professeur">Professeur</option>
                <option value="personnel_admin">Personnel Admin</option>
                <option value="invite">Invite</option>
            </select><br>
        </div><br>
        <div>
            <label for="tel">Telephone</label>
            <input type="text" name="tel" value="{{old('tel')}}" placeholder="Entrez le telephone" required>
            @error('tel')
                <span>{{$message}}</span>
            @enderror
        </div><br>

         <div>
           <label for="username">Nom d'utilisateur</label>
           <input type="text" name="username" placeholder="Entrez le nom d'utilisateur">
            @error('username')
                <span>{{$message}}</span>
            @enderror
        </div><br>
        <div>
            <label for="image">Image</label>
            <input type="text" name="image"  placeholder="entrez l'image">
        </div><br>

        <div>
            <button type="submit">Enregistrer_Client</button>
        </div><br>
    </form>
@endsection
