@extends('pages.include.base')

@section('titre', 'Créer un Utilisateur')
@section('titre_page', 'Créer un Utilisateur')

@section('content')
<div class="w-[98%] mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-semibold mb-6">Créer un nouvel utilisateur</h2>

    <!-- Affichage des erreurs de validation -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

   <form action="{{ route('users.store') }}" method="POST">
    @csrf
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Colonne gauche -->
        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-accent">Nom complet *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                       class="mt-1 block w-full border border-accent rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-accent">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                       class="mt-1 block w-full border border-accent rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary">
            </div>
        </div>

        <!-- Colonne droite -->
        <div class="space-y-4">
            <div>
                <label for="password" class="block text-sm font-medium text-accent">Mot de passe *</label>
                <input type="password" name="password" id="password" required 
                       class="mt-1 block w-full border border-accent rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-accent">Confirmation *</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required 
                       class="mt-1 block w-full border border-accent rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary">
            </div>
        </div>
    </div>

    <!-- Rôle et message d'alerte sur toute la largeur -->
    <div class="grid grid-cols-1 gap-6 mb-6">
        <div>
            <label for="role" class="block text-sm font-medium text-accent">Rôle *</label>
            <select name="role" id="role" required 
                    class="mt-1 block w-full border border-accent rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary">
                <option value="">Sélectionnez un rôle</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Utilisateur</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
            </select>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Important</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>L'utilisateur devra changer son mot de passe à sa première connexion.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Boutons -->
    <div class="flex justify-end space-x-3">
        <a href="{{ route('users.index') }}" class="bg-accent hover:bg-accent/80 text-white hover:font-bold font-medium py-2 px-4 rounded-md">
            Annuler
        </a>
        <button type="submit" class="bg-primary hover:bg-secondary hover:text-accent hover:font-bold text-white font-medium py-2 px-4 rounded-md">
            Créer l'utilisateur
        </button>
    </div>
</form>
</div>
@endsection