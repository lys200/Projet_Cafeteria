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

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Photo de profil -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <div
                                class="w-20 h-20 rounded-full bg-gray-100 border-2 border-gray-200 flex items-center justify-center overflow-hidden">
                                @if(Auth::user()->photo_url)
                                    <img src="{{ Auth::user()->photo_url }}" alt="Photo actuelle"
                                        class="w-full h-full object-cover" id="photoPreview">
                                @else
                                    <!-- Icône SVG par défaut -->
                                    <svg id="photoPreview" class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div
                                class="absolute inset-0 bg-black bg-opacity-40 rounded-full flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity cursor-pointer">
                                <span class="text-white text-xs">Changer</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="photo" id="photo" accept="image/*" class="hidden">
                            <label for="photo"
                                class="cursor-pointer block text-sm text-accent py-2 px-4 rounded-full border-0 bg-primary/10  hover:bg-primary/50 transition-colors">
                                Choisir une image
                            </label>
                            <p class="text-xs text-gray  mt-1">PNG, JPG, GIF, WEBP jusqu'à 2MB</p>
                            @error('photo')
                                <span class="text-red  text-sm">{{ $message }}</span>
                            @enderror

                            <!-- Bouton pour supprimer la photo -->
                            @if(Auth::user()->photo_url)
                                <button type="button" onclick="confirmPhotoDelete()"
                                    class="mt-2 text-xs text-red-600 hover:text-red-800">
                                    Supprimer la photo
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Informations de base -->
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                            class="mt-1 block w-full border border-accent rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary  focus:border-primary ">
                        @error('name')
                            <span class="text-red  text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                            class="mt-1 block w-full border border-accent rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary  focus:border-primary ">
                        @error('email')
                            <span class="text-red  text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Bio -->
            <div class="mb-6">
                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                <textarea name="bio" id="bio" rows="3"
                    class="mt-1 block w-full border border-accent rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary  focus:border-primary ">{{ old('bio', Auth::user()->bio) }}</textarea>
                <p class="text-xs text-gray ">Une courte description de vous-même (500 caractères max)</p>
                @error('bio')
                    <span class="text-red  text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Changement de mot de passe -->
            <div class="border-t border-gray-200 pt-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Changer le mot de passe</h3>

                @if(Auth::user()->force_password_change)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-4">
                        <p class="text-yellow-800 text-sm">
                            <strong>Attention:</strong> Vous devez changer votre mot de passe pour continuer.
                        </p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @unless(Auth::user()->force_password_change)
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe
                                actuel</label>
                            <input type="password" name="current_password" id="current_password"
                                class="mt-1 block w-full border border-accent rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary  focus:border-primary ">
                            @error('current_password')
                                <span class="text-red  text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endunless

                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700">Nouveau mot de
                            passe</label>
                        <input type="password" name="new_password" id="new_password"
                            class="mt-1 block w-full border border-accent rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary  focus:border-primary ">
                        <p class="text-xs text-gray ">8 caractères minimum, avec majuscules, minuscules et chiffres</p>
                        @error('new_password')
                            <span class="text-red  text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le
                            nouveau mot de passe</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                            class="mt-1 block w-full border border-accent rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary  focus:border-primary ">
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('dashboard') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray ">
                    Annuler
                </a>
                <button type="submit"
                    class="bg-primary hover:bg-accent text-white font-medium py-2 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary ">
                    Enregistrer les modifications
                </button>
            </div>
        </form>

        <!-- Section Supprimer le compte -->
        <div class="border-t border-gray-200 mt-8 pt-8">
            <h3 class="text-lg font-medium text-red-600 mb-4">Zone dangereuse</h3>
            <p class="text-sm text-gray-600 mb-4">
                Une fois votre compte supprimé, toutes vos données seront effacées définitivement.
                Avant de continuer, veuillez télécharger toutes les données que vous souhaitez conserver.
            </p>

            <!-- Modal trigger button -->
            <button type="button" onclick="openDeleteModal()"
                class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red ">
                Supprimer mon compte
            </button>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div id="deleteAccountModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-red-600 mb-4">Supprimer votre compte</h3>

                <p class="text-gray-700 mb-4">Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est
                    irréversible.</p>

                <p class="text-sm text-gray-600 mb-4">
                    Pour confirmer la suppression, veuillez entrer votre mot de passe actuel.
                </p>

                <form action="{{ route('profile.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe
                            actuel</label>
                        <input type="password" name="password" id="password" required
                            class="w-full px-3 py-2 border border-accent rounded-md focus:outline-none focus:ring-2 focus:ring-red  focus:border-red ">
                        @error('password')
                            <span class="text-red  text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeDeleteModal()"
                            class="bg-accent hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                            Annuler
                        </button>
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md">
                            Supprimer définitivement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Prévisualisation de l'image
        document.getElementById('photo').addEventListener('change', function (e) {
            const file = e.target.files[0];
            const preview = document.getElementById('photoPreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    // Remplacer l'icône SVG par l'image
                    if (preview.tagName === 'svg') {
                        const container = preview.parentElement;
                        container.innerHTML = `<img src="${e.target.result}" alt="Prévisualisation" class="w-full h-full object-cover" id="photoPreview">`;
                    } else {
                        preview.src = e.target.result;
                    }
                }
                reader.readAsDataURL(file);
            }
        });

        // Confirmation de suppression de photo
        function confirmPhotoDelete() {
            if (confirm('Êtes-vous sûr de vouloir supprimer votre photo de profil ?')) {
                // Ajouter un champ caché pour indiquer la suppression
                const form = document.getElementById('profileForm');
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'delete_photo';
                hiddenInput.value = '1';
                form.appendChild(hiddenInput);

                // Soumettre le formulaire
                form.submit();
            }
        }

        // Clic sur l'avatar pour ouvrir le sélecteur de fichier
        document.querySelector('.relative').addEventListener('click', function (e) {
            if (!e.target.closest('button')) {
                document.getElementById('photo').click();
            }
        });

        // Gestion du modal de suppression de compte
        function openDeleteModal() {
            document.getElementById('deleteAccountModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteAccountModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Fermer le modal en cliquant à l'extérieur
        document.getElementById('deleteAccountModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Fermer le modal avec la touche Échap
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>

    <style>
        .relative {
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .relative:hover {
            transform: scale(1.05);
        }

        #photoPreview {
            transition: all 0.3s ease;
        }

        #deleteAccountModal {
            transition: opacity 0.3s ease;
        }

        /* Animation pour le modal */
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #deleteAccountModal {
            animation: modalFadeIn 0.3s ease-out;
        }

        /* Style pour la zone dangereuse */
        .border-t {
            border-color: #e5e7eb;
        }
    </style>
@endsection