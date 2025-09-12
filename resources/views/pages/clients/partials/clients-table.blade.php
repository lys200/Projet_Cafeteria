@foreach($clients as $client)
    <tr class="client-row" onclick="showClientDetails({{ $client->id }})">
        <td class="px-6 py-4">{{ $client->code_client }}</td>
        <td class="px-6 py-4">{{ $client->nom_client }}</td>
        <td class="px-6 py-4">{{ $client->prenom_client }}</td>
        <td class="px-6 py-4">{{ $client->email }}</td>
        <td class="px-6 py-4">{{ $client->type_client }}</td>
        <td class="px-6 py-4">{{ $client->phone_client }}</td>
        <td class="px-6 py-4">{{ $client->username ?? '-' }}</td>
        @if(auth()->user()->role === 'admin')
            <td class="px-6 py-4">
                <div class="flex space-x-2 justify-center">
                    <!-- Bouton Modifier -->
                    <button onclick="event.stopPropagation(); openEditModal({{ $client->id }});"
                        class="text-blue-600 hover:text-blue-900 group relative" data-tooltip="Modifier">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        <span class="tooltip-text">Modifier</span>
                    </button>

                    <!-- Bouton Supprimer -->
                    <button onclick="event.stopPropagation(); openDeleteModal({{ $client->id }});"
                        class="text-red-600 hover:text-red-900 group relative" data-tooltip="Supprimer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        <span class="tooltip-text">Supprimer</span>
                    </button>
                </div>
            </td>
        @endif
    </tr>
@endforeach

@if($clients->isEmpty())
    <tr>
        <td colspan="8" class="px-6 py-4 text-center">
            <div class="text-center py-8">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z">
                    </path>
                </svg>
                <p class="text-gray-600">Aucun client trouvé</p>
            </div>
        </td>
    </tr>
@endif

@push('script')
    
    <script>
        // Tooltips
        document.querySelectorAll('[data-tooltip]').forEach(element => {
            element.addEventListener('mouseenter', function () {
                const tooltip = this.querySelector('.tooltip-text');
                tooltip.classList.remove('hidden');
                tooltip.classList.add('absolute', 'z-10', 'px-2', 'py-1', 'text-sm', 'text-white', 'bg-gray-800', 'rounded', 'shadow-lg', '-top-8', 'left-1/2', '-translate-x-1/2');
            });

            element.addEventListener('mouseleave', function () {
                const tooltip = this.querySelector('.tooltip-text');
                tooltip.classList.add('hidden');
            });
        });

    </script>

@endpush