@extends('pages.include.base')
@section('title')
    Gestion Clients
@endsection
@section('titre_page')
    Gestion des Clients
@endsection

@section('content')
    <div class="bg-white rounded-lg shadow-md p-2 mb-2">
        <!-- Filtres et barre de recherche -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end text-accent mb-6">
            <!-- Recherche -->
            <div>
                <label class="block text-sm font-medium text-accent mb-2">Rechercher</label>
                <input type="text" id="searchInput" placeholder="Nom, prénom, email ou téléphone..."
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>

            <!-- Type de client -->
            <div>
                <label class="block text-sm font-medium text-accent mb-2">Type de client</label>
                <select id="typeFilter"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="all">Tous</option>
                    @foreach($typesClient as $type)
                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tri -->
            <div>
                <label class="block text-sm font-medium text-accent mb-2">Trier par</label>
                <select id="sortFilter"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="recent">Plus récent</option>
                    <option value="ancien">Plus ancien</option>
                    <option value="nom_asc">Nom (A-Z)</option>
                    <option value="nom_desc">Nom (Z-A)</option>
                </select>
            </div>

            <!-- Bouton Appliquer les filtres -->
            <div>
                <button id="applyFilters"
                    class="bg-primary hover:bg-yellow-900 text-white font-medium py-2 px-4 rounded-md w-full">
                    Appliquer
                </button>
            </div>

                <a href="{{ route('clients.create') }}"
                    class="bg-accent hover:bg-green-800 text-white font-medium py-2 px-4 rounded-md text-center">
                    Nouveau client
                </a>
        </div>
        </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">

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

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-accent/20">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-accent uppercase tracking-wider">#Id</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-accent uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-accent uppercase tracking-wider">Prénom</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-accent uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-accent uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-accent uppercase tracking-wider">Téléphone
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-accent uppercase tracking-wider">Username</th>
                        @if(auth()->user()->role === 'admin')
                            <th class="px-6 py-3 text-left text-xs font-bold text-accent uppercase tracking-wider">Actions</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200" id="clientsTableBody">
                    @include('pages.clients.partials.clients-table', ['clients' => $clients])
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de détail -->
    <div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <h3 class="text-xl font-semibold mb-4">Détails du client</h3>
                <div id="clientDetails"></div>
                <div class="mt-6 flex justify-end">
                    <button onclick="closeModal('detailModal')"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour modifier -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="p-6">
                <h3 class="text-xl font-semibold mb-4">Modifier le client</h3>
                <form id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="edit_nom_client" class="block text-sm font-medium text-accent">Nom</label>
                        <input type="text" name="nom_client" id="edit_nom_client" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <p id="error_nom_client" class="text-red-500 text-xs mt-1 hidden"></p>
                    </div>
                    <div class="mb-4">
                        <label for="edit_prenom_client" class="block text-sm font-medium text-accent">Prénom</label>
                        <input type="text" name="prenom_client" id="edit_prenom_client" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <p id="error_prenom_client" class="text-red-500 text-xs mt-1 hidden"></p>
                    </div>
                    <div class="mb-4">
                        <label for="edit_email" class="block text-sm font-medium text-accent">Email</label>
                        <input type="email" name="email" id="edit_email" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <p id="error_email" class="text-red-500 text-xs mt-1 hidden"></p>
                    </div>
                    <div class="mb-4">
                        <label for="edit_phone_client" class="block text-sm font-medium text-accent">Téléphone</label>
                        <input type="text" name="phone_client" id="edit_phone_client" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <p id="error_phone_client" class="text-red-500 text-xs mt-1 hidden"></p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-accent mb-2">Type Client</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex items-center">
                                <input type="radio" id="edit_type_etudiant" name="type_client" value="etudiant"
                                    class="h-4 w-4 text-primary focus:ring-transparent border-gray-300">
                                <label for="edit_type_etudiant" class="ml-2 block text-sm text-accent">Étudiant</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="edit_type_professeur" name="type_client" value="professeur"
                                    class="h-4 w-4 text-primary focus:ring-transparent border-gray-300">
                                <label for="edit_type_professeur"
                                    class="ml-2 block text-sm text-accent">Professeur</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="edit_type_personnel_admin" name="type_client"
                                    value="personnel_admin"
                                    class="h-4 w-4 text-primary focus:ring-transparent border-gray-300">
                                <label for="edit_type_personnel_admin" class="ml-2 block text-sm text-accent">Personnel
                                    Admin</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="edit_type_invite" name="type_client" value="invite"
                                    class="h-4 w-4 text-primary focus:ring-transparent border-gray-300">
                                <label for="edit_type_invite" class="ml-2 block text-sm text-accent">Invité</label>
                            </div>
                        </div>
                        <p id="error_type_client" class="text-red-500 text-xs mt-1 hidden"></p>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('editModal')"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                            Annuler
                        </button>
                        <button type="submit"
                            class="bg-primary hover:bg-accent text-white font-medium py-2 px-4 rounded-md">
                            Modifier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal pour supprimer -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="p-6">
                <h3 class="text-xl font-semibold mb-4">Supprimer le client</h3>
                <p class="mb-4">Êtes-vous sûr de vouloir supprimer ce client ?</p>
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

    <style>
        .tooltip-text {
            display: none;
            white-space: nowrap;
        }

        .group:hover .tooltip-text {
            display: block;
        }

        .client-row {
            transition: background-color 0.2s ease;
            cursor: pointer;
        }

        .client-row:hover {
            background-color: #f9fafb;
        }

        input[type="radio"] {
            border: 2px solid #d1d5db;
            border-radius: 50%;
        }

        input[type="radio"]:checked {
            border-color: #B77400;
            background-color: #B77400;
        }

        input[type="radio"]:focus {
            outline: none;
            ring: 2px;
            ring-color: #3b82f6;
            ring-opacity: 50%;
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    </style>
@endsection

@push('scripts')
    <script>
        // Variables globales
        let currentClientId = null;
        let activeModal = null;
        let filters = {
            search: '',
            type: 'all',
            sort: 'recent'
        };

        // Initialisation
        document.addEventListener('DOMContentLoaded', function () {
            initializeFilters();
            attachEventListeners();
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
            if (urlParams.has('type')) {
                filters.type = urlParams.get('type');
                document.getElementById('typeFilter').value = filters.type;
            }
            if (urlParams.has('sort')) {
                filters.sort = urlParams.get('sort');
                document.getElementById('sortFilter').value = filters.sort;
            }
        }

        // Attacher les événements
        function attachEventListeners() {
            // Événements pour les formulaires
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

            // Fermer les modals avec la touche Échap
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && activeModal) {
                    closeModal(activeModal);
                }
            });

            // Tooltips
            document.querySelectorAll('[data-tooltip]').forEach(element => {
                element.addEventListener('mouseenter', function () {
                    const tooltip = this.querySelector('.tooltip-text');
                    tooltip.classList.remove('hidden');
                    tooltip.classList.add('absolute', 'z-10', 'px-2', 'r-5', 'py-1', 'text-sm', 'text-white', 'bg-gray-800', 'rounded', 'shadow-lg', '-top-8', 'left-1/2', '-translate-x-1/2');
                });

                element.addEventListener('mouseleave', function () {
                    const tooltip = this.querySelector('.tooltip-text');
                    tooltip.classList.add('hidden');
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
            if (modalId) {
                document.getElementById(modalId).classList.add('hidden');
            } else if (activeModal) {
                document.getElementById(activeModal).classList.add('hidden');
            }
            document.body.classList.remove('overflow-hidden');
            clearErrors();
            activeModal = null;
        }

        // Application des filtres
        function applyFilters() {
            // Récupérer les valeurs des filtres
            filters.search = document.getElementById('searchInput').value;
            filters.type = document.getElementById('typeFilter').value;
            filters.sort = document.getElementById('sortFilter').value;

            const params = new URLSearchParams();

            // Ajouter seulement les filtres non-vides
            if (filters.search) params.append('search', filters.search);
            if (filters.type !== 'all') params.append('type_client', filters.type);
            if (filters.sort !== 'recent') params.append('sort', filters.sort);
            params.append('ajax', '1');

            fetch(`/clients?${params.toString()}`, {
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
                        document.getElementById('clientsTableBody').innerHTML = data.html;
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
        function showClientDetails(clientId) {
            fetch(`/clients/${clientId}`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(client => {
                    const detailsHtml = `
                                    <div class="space-y-4">
                                        <div class="flex items-center space-x-6">
                                            <div>
                                                <h4 class="text-2xl font-bold text-gray-800">${client.nom_client} ${client.prenom_client}</h4>
                                                <p class="text-primary-600 font-semibold">${client.code_client}</p>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <span class="text-sm font-medium text-gray-600">Email:</span>
                                                <p class="text-gray-800">${client.email}</p>
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium text-gray-600">Téléphone:</span>
                                                <p class="text-gray-800">${client.phone_client}</p>
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium text-gray-600">Type:</span>
                                                <span class="px-2 py-1 bg-primary-100 text-primary-800 text-sm rounded-full">${client.type_client}</span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium text-gray-600">Username:</span>
                                                <p class="text-gray-800">${client.username || 'Non défini'}</p>
                                            </div>
                                        </div>

                                        <div>
                                            <span class="text-sm font-medium text-gray-600">Date de création:</span>
                                            <p class="text-gray-800">${new Date(client.created_at).toLocaleDateString()}</p>
                                        </div>
                                    </div>
                                `;

                    document.getElementById('clientDetails').innerHTML = detailsHtml;
                    openModal('detailModal');
                })
                .catch(error => {
                    console.error('Error loading client details:', error);
                    showFlashMessage('Erreur lors du chargement des détails', 'error');
                });
        }


        // Modifier
        function openEditModal(clientId) {
            // Fermer tout modal ouvert
            if (activeModal) {
                closeModal(activeModal);
            }

            fetch(`/clients/${clientId}/edit`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(client => {
                    console.log('Données client reçues:', client);

                    // Ouvrir le modal d'abord
                    document.getElementById('editForm').action = `/clients/${clientId}`;
                    currentClientId = clientId;
                    openModal('editModal');

                    // Remplir les champs du formulaire après l'ouverture du modal
                    setTimeout(() => {
                        // Remplir les champs texte
                        document.getElementById('edit_nom_client').value = client.nom_client || '';
                        document.getElementById('edit_prenom_client').value = client.prenom_client || '';
                        document.getElementById('edit_email').value = client.email || '';
                        document.getElementById('edit_phone_client').value = client.phone_client || '';

                        // Sélectionner le radio button correspondant
                        if (client.type_client) {
                            const radioButton = document.querySelector(`input[name="type_client"][value="${client.type_client}"]`);
                            if (radioButton) {
                                radioButton.checked = true;
                                console.log('Bouton radio sélectionné:', client.type_client);
                            } else {
                                console.error('Aucun bouton radio trouvé pour la valeur:', client.type_client);
                            }
                        }
                    }, 50);
                })
                .catch(error => {
                    console.error('Error loading client for edit:', error);
                    showFlashMessage('Erreur lors du chargement du client', 'error');
                });
        }

        // Soumettre la modification
        async function handleEditSubmit(e) {
            e.preventDefault();
            clearErrors();

            // Récupérer les données du formulaire
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    showFlashMessage(result.success, 'success');
                    closeModal('editModal');
                    // Appliquer les filtres pour rafraîchir le tableau
                    applyFilters();
                } else {
                    showErrorsInModal(result.errors);
                }
            } catch (error) {
                console.error('Error updating client:', error);
                showFlashMessage('Une erreur est survenue lors de la modification', 'error');
            }
        }

        // Attacher les événements
        document.addEventListener('DOMContentLoaded', function () {
            // ... autres initialisations

            // Attacher l'événement submit au formulaire
            document.getElementById('editForm').addEventListener('submit', handleEditSubmit);
        });

        // Supprimer
        function openDeleteModal(clientId) {
            document.getElementById('deleteForm').action = `/clients/${clientId}`;
            currentClientId = clientId;
            openModal('deleteModal');
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
                    // Appliquer les filtres pour rafraîchir le tableau
                    applyFilters();
                } else {
                    showErrorsInModal(result.errors);
                }
            } catch (error) {
                console.error('Error updating client:', error);
                showFlashMessage('Une erreur est survenue lors de la modification', 'error');
            }
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
                    // Appliquer les filtres pour rafraîchir le tableau
                    applyFilters();
                } else {
                    showFlashMessage(result.error, 'error');
                }
            } catch (error) {
                console.error('Error deleting client:', error);
                showFlashMessage('Une erreur est survenue lors de la suppression', 'error');
            }
        }

        // Fonction pour afficher les erreurs dans le modal
        function showErrorsInModal(errors) {
            clearErrors();

            for (const [field, messages] of Object.entries(errors)) {
                const errorElement = document.getElementById('error_' + field);
                if (errorElement) {
                    errorElement.textContent = messages[0];
                    errorElement.classList.remove('hidden');
                }
            }
        }

        // Fonction pour effacer les erreurs
        function clearErrors() {
            document.querySelectorAll('.text-red-500.text-xs.mt-1').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });
        }

        // Afficher les messages flash
        function showFlashMessage(message, type) {
            const flashDiv = document.getElementById('flash-messages');
            const alertDiv = document.createElement('div');
            alertDiv.className = `px-4 py-3 rounded mb-4 ${type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'}`;
            alertDiv.textContent = message;
            flashDiv.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
    </script>
@endpush