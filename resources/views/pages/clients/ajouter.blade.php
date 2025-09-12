@extends('pages.include.base')
@section('title')
    Gestion Clients
@endsection
@section('titre_page')
    Formulaire de Saisie de Clients
@endsection

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
        <!-- Messages flash -->
        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
                <button type="button" class="absolute top-0 right-0 mt-3 mr-3 text-green-700 hover:text-green-900"
                    onclick="this.parentElement.style.display='none'">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        {{-- formulaire de saisie des infos sur le client --}}
        <form action="{{ route('clients.store') }}" method="post" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nom -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-accent mb-1">Nom Client</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Entrez le nom" required
                        class="w-full px-4 py-2 border border-accent/50 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                    @error('nom')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Prénom -->
                <div>
                    <label for="prenom" class="block text-sm font-medium text-accent mb-1">Prénom Client</label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Entrez le prénom" required
                        class="w-full px-4 py-2 border border-accent/50 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                    @error('prenom')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-accent mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Entrez l'email" required
                    class="w-full px-4 py-2 border border-accent/50 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Type de client et Téléphone -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Type client -->
                <div>
                    <label for="type_client" class="block text-sm font-medium text-accent mb-1">Type de Client</label>
                    <select name="type_client" required
                        class="w-full px-4 py-2 border border-accent/50 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                        <option value="">-- Selectionnez une option--</option>
                        <option value="etudiant" {{ old('type_client') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                        <option value="professeur" {{ old('type_client') == 'professeur' ? 'selected' : '' }}>Professeur
                        </option>
                        <option value="personnel_admin" {{ old('type_client') == 'personnel_admin' ? 'selected' : '' }}>
                            Personnel Admin</option>
                        <option value="invite" {{ old('type_client') == 'invite' ? 'selected' : '' }}>Invité</option>
                    </select>
                    @error('type_client')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div>
                    <label for="tel" class="block text-sm font-medium text-accent mb-1">Téléphone</label>
                    <input type="text" name="tel" value="{{ old('tel') }}" placeholder="Entrez le téléphone" required
                        class="w-full px-4 py-2 border border-accent/50 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                    @error('tel')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Nom d'utilisateur et Image -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nom d'utilisateur -->
                <div>
                    <label for="username" class="block text-sm font-medium text-accent mb-1">Nom d'utilisateur</label>
                    <input type="text" name="username" value="{{ old('username') }}"
                        placeholder="Entrez le nom d'utilisateur"
                        class="w-full px-4 py-2 border border-accent/50 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                    @error('username')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-accent mb-1">Image (URL)</label>
                    <input type="text" name="image" value="{{ old('image') }}" placeholder="Entrez l'URL de l'image"
                        class="w-full px-4 py-2 border border-accent/50 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                    @error('image')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Bouton de soumission -->
            <div class="  pt-4 flex justify-end">
                <div class="w-1/2 flex justify-between">

                    <a href="{{ route('client.index') }}"
                        class="text-primary hover:text-accent hover:font-bold font-medium flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Annuler
                    </a>
                    <button type="submit"
                        class=" bg-primary hover:bg-primary-700 text-white font-bold py-3 px-4 rounded-lg transition duration-150 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                        Enregistrer le Client
                    </button>
                </div>

            </div>
        </form>

        <!-- Lien de retour -->
        <div class="mt-6 text-center">

        </div>
    </div>

    <style>
        /* Animation douce pour les champs de formulaire */
        input,
        select {
            transition: all 0.3s ease;
        }

        /* Style pour les messages d'erreur */
        .text-red-500 {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Effet de focus amélioré */
        input:focus,
        select:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
@endsection