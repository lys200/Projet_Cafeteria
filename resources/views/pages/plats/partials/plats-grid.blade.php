@foreach($plats as $plat)
<div class="bg-white hover:border-2 hover:border-secondary rounded-lg shadow-md overflow-hidden transition-all duration-200 hover:shadow-lg {{ !$plat->disponible_jour ? 'opacity-60' : '' }}" data-plat-id="{{ $plat->id }}">
    <div class="h-36 bg-primary overflow-hidden cursor-pointer" onclick="showPlatDetails({{ $plat->id }})">
        @if($plat->image)
            <img src="{{ asset('storage/images/plats/' . $plat->image) }}" alt="{{ $plat->nom_plat }}"
                 class="w-full h-full object-cover">
        @else
            <img src="{{ asset('images/default_plat.png') }}" alt="{{ $plat->nom_plat }}"
                 class="w-full h-full object-cover">
        @endif
    </div>
    <div class="py-2 px-4">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-lg mr-5 font-semibold text-gray-800 cursor-pointer" onclick="showPlatDetails({{ $plat->id }})">{{ $plat->nom_plat }}</h3>
            <span class="h-3 w-3 rounded-full {{ $plat->disponible_jour ? 'bg-green-600' : 'bg-red-600' }}"></span>
        </div>
        
        <div class="flex justify-start items-center mb-3">
            <span class="px-2 py-1 mr-5 bg-primary/50 text-accent text-xs rounded-full">
                {{ ucfirst($plat->categorie) }}
            </span>
            <span class="bg-secondary/50 mr-5  text-accent text-xs px-2 py-1 rounded-full">
                {{ $plat->cuisson }}
            </span>
        </div>
        
        <p class="text-gray-600 text-sm mb-3 line-clamp-2 cursor-pointer" onclick="showPlatDetails({{ $plat->id }})">
            {{ $plat->description ?: 'Aucune description' }}
        </p>
        <div class="flex justify-between items-center cursor-pointer" onclick="showPlatDetails({{ $plat->id }})">
            <span class="text-sm text-gray-500">Stock: {{ $plat->quantite }}</span>
            <span class="text-primary-600 font-bold">{{ number_format($plat->prix, 0, ',', ' ') }} HTG</span>
        </div>
        
        @auth
            @if(Auth::user()->isAdmin())
            <div class="flex justify-end space-x-2 mt-3 pt-3 border-t border-gray-100">
                <button onclick="event.stopPropagation(); openEditModal({{ $plat->id }});" class="text-blue-600 hover:text-blue-800" title="Modifier">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </button>
                <button onclick="event.stopPropagation(); openDeleteModal({{ $plat->id }});" class="text-red-600 hover:text-red-800" title="Supprimer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                </button>
            </div>
            @endif
        @endauth
    </div>
</div>
@endforeach

@if($plats->isEmpty())
<div class="col-span-full text-center py-12">
    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.5 1.5 0 013 15.546V5a2 2 0 012-2h14a2 2 0 012 2v10.546z"></path>
    </svg>
    <p class="text-gray-600">Aucun plat trouvé</p>
</div>
@endif