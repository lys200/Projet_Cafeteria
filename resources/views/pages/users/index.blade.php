@extends('pages.include.base')

@section('titre', 'Gestion des Utilisateurs')
@section('titre_page', 'Gestion des Utilisateurs')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Liste des Utilisateurs</h2>
        <a href="{{ route('users.create') }}" class="bg-primary hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-md">
            Nouvel Utilisateur
        </a>
    </div>

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
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="cursor-pointer hover:bg-gray-50 user-row" data-user-id="{{ $user->id }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="h-8 w-8 rounded-full object-cover mr-3">
                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <!-- Bouton Modifier -->
                            <button onclick="openEditModal({{ $user->id }})" class="text-blue-600 hover:text-blue-900 group relative" data-tooltip="Modifier">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span class="tooltip-text">Modifier</span>
                            </button>

                            <!-- Bouton Supprimer -->
                            @if($user->id !== auth()->id())
                            <button onclick="openDeleteModal({{ $user->id }})" class="text-red-600 hover:text-red-900 group relative" data-tooltip="Supprimer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span class="tooltip-text">Supprimer</span>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal pour voir les détails -->
<div id="viewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="p-6">
            <h3 class="text-xl font-semibold mb-4">Détails de l'utilisateur</h3>
            <div id="userDetails"></div>
            <div class="mt-6 flex justify-end">
                <button onclick="closeModal('viewModal')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
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
            <h3 class="text-xl font-semibold mb-4">Modifier l'utilisateur</h3>
            <form id="editForm">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="name" id="edit_name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="mb-4">
                    <label for="edit_email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="edit_email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="mb-4">
                    <label for="edit_role" class="block text-sm font-medium text-gray-700">Rôle</label>
                    <select name="role" id="edit_role" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <option value="user">Utilisateur</option>
                        <option value="admin">Administrateur</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="edit_bio" class="block text-sm font-medium text-gray-700">Bio</label>
                    <textarea name="bio" id="edit_bio" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('editModal')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                        Annuler
                    </button>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-md">
                        Enregistrer
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
            <h3 class="text-xl font-semibold mb-4">Supprimer l'utilisateur</h3>
            <p class="mb-4">Êtes-vous sûr de vouloir supprimer cet utilisateur ?</p>
            <form id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('deleteModal')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                        Annuler
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md">
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
let currentUserId = null;

// Tooltips
document.querySelectorAll('[data-tooltip]').forEach(element => {
    element.addEventListener('mouseenter', function() {
        const tooltip = this.querySelector('.tooltip-text');
        tooltip.classList.remove('hidden');
        tooltip.classList.add('absolute', 'z-10', 'px-2', 'py-1', 'text-sm', 'text-white', 'bg-gray-800', 'rounded', 'shadow-lg', '-top-8', 'left-1/2', '-translate-x-1/2');
    });
    
    element.addEventListener('mouseleave', function() {
        const tooltip = this.querySelector('.tooltip-text');
        tooltip.classList.add('hidden');
    });
});

// Modal functions
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

// Voir les détails
document.querySelectorAll('.user-row').forEach(row => {
    row.addEventListener('click', function(e) {
        if (!e.target.closest('button')) {
            const userId = this.dataset.userId;
            fetchUserDetails(userId);
        }
    });
});

async function fetchUserDetails(userId) {
    try {
        const response = await fetch(`/users/${userId}`);
        const user = await response.json();
        
        const detailsHtml = `
            <div class="space-y-3">
                <div class="flex items-center space-x-4">
                    <img src="${user.photo_url}" alt="${user.name}" class="w-16 h-16 rounded-full object-cover">
                    <div>
                        <h4 class="text-lg font-semibold">${user.name}</h4>
                        <p class="text-gray-600">${user.email}</p>
                    </div>
                </div>
                <div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full ${user.role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'}">
                        ${user.role}
                    </span>
                </div>
                ${user.bio ? `<div><p class="text-gray-700">${user.bio}</p></div>` : ''}
            </div>
        `;
        
        document.getElementById('userDetails').innerHTML = detailsHtml;
        openModal('viewModal');
    } catch (error) {
        console.error('Erreur:', error);
    }
}

// Modifier
async function openEditModal(userId) {
    try {
        const response = await fetch(`/users/${userId}/edit`);
        const user = await response.json();
        
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = user.role;
        document.getElementById('edit_bio').value = user.bio || '';
        
        document.getElementById('editForm').action = `/users/${userId}`;
        currentUserId = userId;
        openModal('editModal');
    } catch (error) {
        console.error('Erreur:', error);
    }
}

// Soumettre la modification
document.getElementById('editForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
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
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showFlashMessage(result.error, 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showFlashMessage('Une erreur est survenue', 'error');
    }
});

// Supprimer
function openDeleteModal(userId) {
    document.getElementById('deleteForm').action = `/users/${userId}`;
    currentUserId = userId;
    openModal('deleteModal');
}

document.getElementById('deleteForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    try {
        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-HTTP-Method-Override': 'DELETE'
            }
        });
        
        const result = await response.json();
        
        if (response.ok) {
            showFlashMessage(result.success, 'success');
            closeModal('deleteModal');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showFlashMessage(result.error, 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showFlashMessage('Une erreur est survenue', 'error');
    }
});

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

<style>
.tooltip-text {
    display: none;
    white-space: nowrap;
}
.group:hover .tooltip-text {
    display: block;
}
.user-row {
    transition: background-color 0.2s ease;
}
</style>
@endpush