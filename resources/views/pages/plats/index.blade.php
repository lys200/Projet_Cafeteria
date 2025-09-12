@extends('pages.include.base')

@section('titre', 'Gestion des Plats')
@section('titre_page', 'Gestion des Plats')

@section('content')
    <div class=" mx-auto px-4">
        <!-- Filtres et barre de recherche -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end text-accent">
                <!-- Recherche -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                    <input type="text" id="searchInput" placeholder="Nom du plat..."
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>

                <!-- Catégorie -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                    <select id="categorieFilter"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="all">Toutes</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie }}">{{ ucfirst($categorie) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Disponibilité -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Disponibilité</label>
                    <select id="disponibleFilter"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="all">Tous</option>
                        <option value="1">Disponible</option>
                        <option value="0">Indisponible</option>
                    </select>
                </div>

                <!-- Tri -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
                    <select id="sortFilter"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="recent">Plus récent</option>
                        <option value="ancien">Plus ancien</option>
                        <option value="prix_asc">Prix croissant</option>
                        <option value="prix_desc">Prix décroissant</option>
                        <option value="quantite_asc">Quantité croissante</option>
                        <option value="quantite_desc">Quantité décroissante</option>
                    </select>
                </div>

                <!-- Bouton Appliquer les filtres -->
                <div>
                    <button id="applyFilters"
                        class="bg-primary hover:bg-accent text-white font-medium py-2 px-4 rounded-md w-full">
                        Appliquer
                    </button>
                </div>

                <!-- Bouton Ajouter -->
                <div>
                    <a href="{{ route('plats.create') }}"
                        class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md w-full block text-center">
                        Nouveau Plat
                    </a>
                </div>
            </div>
        </div>

        <!-- Messages flash -->
        <div id="flashMessages">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <!-- Grille des plats -->
        <div id="platsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @include('pages.plats.partials.plats-grid', ['plats' => $plats])
        </div>
    </div>

    <!-- Modal de détail -->
    <div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <h3 class="text-xl font-semibold mb-4" id="modalTitle">Détails du plat</h3>
                <div id="platDetails"></div>
                <div class="mt-6 flex justify-end">
                    <button onclick="closeModal('detailModal')"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'édition -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <h3 class="text-xl font-semibold mb-4">Modifier le plat</h3>
                <form id="editForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="edit_nom_plat" class="block text-sm font-medium text-gray-700">Nom du plat *</label>
                            <input type="text" name="nom_plat" id="edit_nom_plat" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            <p id="error_nom_plat" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>
                        <div>
                            <label for="edit_cuisson" class="block text-sm font-medium text-gray-700">Cuisson *</label>
                            <select name="cuisson" id="edit_cuisson" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                <option value="Cru">Cru</option>
                                <option value="Cuit">Cuit</option>
                                <option value="Grillé">Grillé</option>
                            </select>
                            <p id="error_cuisson" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>
                        <div>
                            <label for="edit_prix" class="block text-sm font-medium text-gray-700">Prix (HTG) *</label>
                            <input type="number" name="prix" id="edit_prix" step="0.01" min="0" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            <p id="error_prix" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>
                        <div>
                            <label for="edit_categorie" class="block text-sm font-medium text-gray-700">Catégorie *</label>
                            <select name="categorie" id="edit_categorie" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                <option value="dejeuner">Déjeuner</option>
                                <option value="diner">Dîner</option>
                                <option value="dessert">Dessert</option>
                                <option value="boisson">Boisson</option>
                                <option value="snack">Snack</option>
                            </select>
                            <p id="error_categorie" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>
                        <div>
                            <label for="edit_quantite" class="block text-sm font-medium text-gray-700">Quantité *</label>
                            <input type="number" name="quantite" id="edit_quantite" min="0" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            <p id="error_quantite" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="disponible_jour" id="edit_disponible_jour" value="1" class="mr-2">
                            <label for="edit_disponible_jour" class="text-sm font-medium text-gray-700">Disponible
                                aujourd'hui</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="edit_description" rows="3"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500"></textarea>
                        <p id="error_description" class="text-red-500 text-xs mt-1 hidden"></p>
                    </div>
                    <div class="mb-4">
                        <label for="edit_image" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" name="image" id="edit_image" accept="image/*" class="mt-1 block w-full">
                        <p id="error_image" class="text-red-500 text-xs mt-1 hidden"></p>
                        <div id="currentImage" class="mt-2"></div>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('editModal')"
                            class="bg-accent hover:bg-accent/90 text-white font-medium py-2 px-4 rounded-md">
                            Annuler
                        </button>
                        <button type="submit"
                            class="bg-primary hover:bg-accent text-white font-medium py-2 px-4 rounded-md">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de suppression -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="p-6">
                <h3 class="text-xl font-semibold mb-4">Supprimer le plat</h3>
                <p class="mb-4">Êtes-vous sûr de vouloir supprimer ce plat ? Cette action est irréversible.</p>
                <form id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('deleteModal')"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                            Annuler
                        </button>
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md">
                            Supprimer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Variables globales
        let currentPlatId = null;
        let filters = {
            search: '',
            categorie: 'all',
            disponible: 'all',
            sort: 'recent'
        };
        let activeModal = null;

        // Initialisation
        document.addEventListener('DOMContentLoaded', function () {
            initializeFilters();
            attachInitialEventListeners();
            attachDynamicEventListeners();
        });

        // Initialisation des filtres
        function initializeFilters() {
            // Écouteur pour le bouton Appliquer
            document.getElementById('applyFilters').addEventListener('click', function () {
                applyFilters();
            });

            // Initialiser les valeurs des filtres depuis l'URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('search')) {
                filters.search = urlParams.get('search');
                document.getElementById('searchInput').value = filters.search;
            }
            if (urlParams.has('categorie')) {
                filters.categorie = urlParams.get('categorie');
                document.getElementById('categorieFilter').value = filters.categorie;
            }
            if (urlParams.has('disponible')) {
                filters.disponible = urlParams.get('disponible');
                document.getElementById('disponibleFilter').value = filters.disponible;
            }
            if (urlParams.has('sort')) {
                filters.sort = urlParams.get('sort');
                document.getElementById('sortFilter').value = filters.sort;
            }
        }

        // Attacher les événements initiaux
        function attachInitialEventListeners() {
            // Événements pour les modals
            document.getElementById('editForm').addEventListener('submit', handleEditSubmit);
            document.getElementById('deleteForm').addEventListener('submit', handleDeleteSubmit);

            // Fermer les modals en cliquant à l'extérieur
            document.querySelectorAll('[id$="Modal"]').forEach(modal => {
                modal.addEventListener('click', function (e) {
                    if (e.target === this) {
                        closeModal(this.id);
                    }
                });
            });
        }

        // Fonctions de modal
        function openModal(modalId) {
            // Fermer tout modal ouvert
            if (activeModal) {
                closeModal(activeModal);
            }

            document.getElementById(modalId).classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            activeModal = modalId;
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            clearErrors();
            activeModal = null;
        }

        // Application des filtres
        function applyFilters() {
            // Récupérer les valeurs des filtres
            filters.search = document.getElementById('searchInput').value;
            filters.categorie = document.getElementById('categorieFilter').value;
            filters.disponible = document.getElementById('disponibleFilter').value;
            filters.sort = document.getElementById('sortFilter').value;

            console.log('Applying filters:', filters);

            const params = new URLSearchParams();

            // Ajouter seulement les filtres non-vides
            if (filters.search) params.append('search', filters.search);
            if (filters.categorie !== 'all') params.append('categorie', filters.categorie);
            if (filters.disponible !== 'all') params.append('disponible', filters.disponible);
            if (filters.sort !== 'recent') params.append('sort', filters.sort);
            params.append('ajax', '1');

            fetch(`/plats?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.html) {
                        document.getElementById('platsGrid').innerHTML = data.html;
                        attachDynamicEventListeners();
                    } else {
                        console.error('No HTML content in response:', data);
                    }
                })
                .catch(error => {
                    console.error('Error applying filters:', error);
                    showFlashMessage('Erreur lors du filtrage', 'error');
                });
        }

        // Voir les détails
        function showPlatDetails(platId) {
            fetch(`/plats/${platId}`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(plat => {
                    const detailsHtml = `
                            <div class="space-y-4">
                                <div class="flex items-center space-x-12">
                                    <div>
                                        <h4 class="text-2xl font-bold text-gray-800">${plat.nom_plat}</h4>
                                        <p class="text-primary-600 font-semibold">${plat.prix} HTG</p>
                                    </div>
                                    <div class="w-24 h-24 bg-gray-200 rounded-lg overflow-hidden">
                                        ${plat.image ?
                            `<img src="/storage/images/plats/${plat.image}" alt="${plat.nom_plat}" class="w-full h-full object-cover">` :
                            `<div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.5 1.5 0 013 15.546V5a2 2 0 012-2h14a2 2 0 012 2v10.546z"></path>
                                                </svg>
                                            </div>`
                        }
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-md font-medium text-gray-600">Cuisson:</span>
                                        <span class="text-gray-800 text-md font-bold">${plat.cuisson}</span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Catégorie:</span>
                                        <span class="px-2 font-bold py-1 bg-primary-100 text-primary-800 text-md rounded-full">${plat.categorie}</span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Quantité:</span>
                                        <span class="text-gray-800 font-bold">${plat.quantite}</span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Disponible:</span>
                                        <span class="text-gray-800 font-bold">${plat.disponible_jour ? 'Oui' : 'Non'}</span>
                                    </div>
                                </div>

                                ${plat.description ? `
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Description:</span>
                                    <p class="text-gray-800">${plat.description}</p>
                                </div>
                                ` : ''}

                                <div>
                                    <span class="text-sm font-medium text-gray-600">Code:</span>
                                    <p class="text-gray-800">${plat.code_plat}</p>
                                </div>
                            </div>
                        `;

                    document.getElementById('platDetails').innerHTML = detailsHtml;
                    openModal('detailModal');
                })
                .catch(error => {
                    console.error('Error loading plat details:', error);
                    showFlashMessage('Erreur lors du chargement des détails', 'error');
                });
        }

        // Modifier
        function openEditModal(platId) {
            fetch(`/plats/${platId}/edit`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(plat => {
                    document.getElementById('edit_nom_plat').value = plat.nom_plat;
                    document.getElementById('edit_cuisson').value = plat.cuisson;
                    document.getElementById('edit_prix').value = plat.prix;
                    document.getElementById('edit_categorie').value = plat.categorie;
                    document.getElementById('edit_quantite').value = plat.quantite;
                    document.getElementById('edit_disponible_jour').checked = plat.disponible_jour;
                    document.getElementById('edit_description').value = plat.description || '';

                    // Afficher l'image actuelle
                    const currentImageDiv = document.getElementById('currentImage');
                    if (plat.image) {
                        currentImageDiv.innerHTML = `
                                <p class="text-sm text-gray-600">Image actuelle:</p>
                                <img src="/storage/images/plats/${plat.image}" alt="${plat.nom_plat}" class="w-24 h-24 object-cover rounded mt-2">
                            `;
                    } else {
                        currentImageDiv.innerHTML = '<p class="text-sm text-gray-600">Aucune image</p>';
                    }

                    document.getElementById('editForm').action = `/plats/${platId}`;
                    currentPlatId = platId;
                    openModal('editModal');
                })
                .catch(error => {
                    console.error('Error loading plat for edit:', error);
                    showFlashMessage('Erreur lors du chargement du plat', 'error');
                });
        }

        // Soumettre la modification
        async function handleEditSubmit(e) {
            e.preventDefault();
            clearErrors();

            const formData = new FormData(this);

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'PUT'
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    showFlashMessage(result.success, 'success');
                    closeModal('editModal');
                    // Appliquer les filtres pour rafraîchir la grille
                    applyFilters();
                } else {
                    showErrorsInModal(result.errors);
                }
            } catch (error) {
                console.error('Error updating plat:', error);
                showFlashMessage('Une erreur est survenue lors de la modification', 'error');
            }
        }

        // Supprimer
        function openDeleteModal(platId) {
            document.getElementById('deleteForm').action = `/plats/${platId}`;
            currentPlatId = platId;
            openModal('deleteModal');
        }

        async function handleDeleteSubmit(e) {
            e.preventDefault();

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE'
                    },
                    body: JSON.stringify({})
                });

                const result = await response.json();

                if (response.ok) {
                    showFlashMessage(result.success, 'success');
                    closeModal('deleteModal');
                    // Appliquer les filtres pour rafraîchir la grille
                    applyFilters();
                } else {
                    showFlashMessage(result.error, 'error');
                }
            } catch (error) {
                console.error('Error deleting plat:', error);
                showFlashMessage('Une erreur est survenue lors de la suppression', 'error');
            }
        }

        // Fonction pour afficher les erreurs dans le modal
        function showErrorsInModal(errors) {
            clearErrors();

            if (typeof errors === 'string') {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4';
                errorDiv.textContent = errors;
                document.getElementById('editForm').prepend(errorDiv);
                return;
            }

            for (const [field, messages] of Object.entries(errors)) {
                const fieldElement = document.getElementById('edit_' + field);
                const errorElement = document.getElementById('error_' + field);

                if (fieldElement) {
                    fieldElement.classList.add('border-red-500', 'border-2');
                }

                if (errorElement) {
                    errorElement.textContent = messages[0];
                    errorElement.classList.remove('hidden');
                } else if (fieldElement) {
                    const newErrorElement = document.createElement('p');
                    newErrorElement.id = 'error_' + field;
                    newErrorElement.className = 'text-red-500 text-xs mt-1';
                    newErrorElement.textContent = messages[0];
                    fieldElement.parentNode.appendChild(newErrorElement);
                }
            }
        }

        // Fonction pour effacer les erreurs
        function clearErrors() {
            document.querySelectorAll('.border-red-500').forEach(el => {
                el.classList.remove('border-red-500', 'border-2');
            });

            document.querySelectorAll('.text-red-500.text-xs.mt-1').forEach(el => {
                el.remove();
            });

            document.querySelectorAll('.bg-red-100.border-red-400').forEach(el => {
                el.remove();
            });
        }

        // Afficher les messages flash
        function showFlashMessage(message, type) {
            const flashDiv = document.getElementById('flashMessages');
            const alertDiv = document.createElement('div');
            alertDiv.className = `px-4 py-3 rounded mb-6 ${type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'}`;
            alertDiv.textContent = typeof message === 'object' ? Object.values(message).join(', ') : message;
            flashDiv.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        // Attacher les événements dynamiques après le rafraîchissement
        function attachDynamicEventListeners() {
            // Événements pour les cartes (détails)
            document.querySelectorAll('[data-plat-id]').forEach(card => {
                card.addEventListener('click', function (e) {
                    // Empêcher l'ouverture des détails si on clique sur un bouton d'édition/suppression
                    if (!e.target.closest('button') && !e.target.closest('a')) {
                        const platId = this.dataset.platId;
                        showPlatDetails(platId);
                    }
                });
            });

            // Événements pour les boutons d'édition
            document.querySelectorAll('[data-edit-plat]').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const platId = this.dataset.editPlat;
                    openEditModal(platId);
                });
            });

            // Événements pour les boutons de suppression
            document.querySelectorAll('[data-delete-plat]').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const platId = this.dataset.deletePlat;
                    openDeleteModal(platId);
                });
            });
        }
    </script>
@endpush