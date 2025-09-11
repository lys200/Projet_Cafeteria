@extends('pages.include.base')

@section('titre', 'Mon Profil')
@section('titre_page', 'Mon Profil')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-semibold mb-6">Modifier mon profil</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Photo de profil -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
                <div class="flex items-center space-x-4">
                    <img src="{{ Auth::user()->photo_url }}" alt="Photo actuelle" class="w-20 h-20 rounded-full object-cover">
                    <div>
                        <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF jusqu'à 2MB</p>
                    </div>
                </div>
            </div>

            <!-- Informations de base -->
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                    <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Bio -->
        <div class="mb-6">
            <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
            <textarea name="bio" id="bio" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">{{ old('bio', Auth::user()->bio) }}</textarea>
            <p class="text-xs text-gray-500">Une courte description de vous-même</p>
            @error('bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Changement de mot de passe -->
        <div class="border-t border-gray-200 pt-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Changer le mot de passe</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                    <input type="password" name="current_password" id="current_password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                    <input type="password" name="new_password" id="new_password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('new_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection