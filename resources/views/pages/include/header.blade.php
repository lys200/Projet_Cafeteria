<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-primary text-white transform transition-transform duration-200 ease-in-out md:translate-x-0 -translate-x-full" 
        :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }" 
        x-cloak>
    <!-- Logo et nom du pt -->
    <div class="flex items-center justify-between p-4 border-b border-light">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/default3.png') }}" alt="logo cafet" class="h-16">
            <span class="text-xl font-bold">Cafet-CHCL</span>
        </div>
        <!-- Bouton fermer sidebar sur mobile -->
        <button @click="sidebarOpen = false" class="md:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="p-4">
        <ul class="space-y-2">
            <!-- Tableau de bord -->
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center p-3 rounded-lg transition-colors duration-200 hover:bg-accent font-bold {{ request()->routeIs('dashboard') ? 'bg-accent' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Gestion des plats -->
            <li>
                <a href="{{ route('plats.index') }}" class="flex items-center p-3 rounded-lg font-bold transition-colors duration-200 hover:bg-accent {{ request()->routeIs('plats.*') ? 'bg-accent' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.5 1.5 0 013 15.546V5a2 2 0 012-2h14a2 2 0 012 2v10.546z"></path>
                    </svg>
                    <span>Gestion des plats</span>
                </a>
            </li>

            <!-- Gestion des clients -->
            <li>
                <a href="{{ route('client.index') }}" class="flex items-center p-3 rounded-lg font-bold transition-colors duration-200 hover:bg-accent {{ request()->routeIs('clients.*') ? 'bg-accent' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Gestion des clients</span>
                </a>
            </li>

            <!-- Gestion des ventes -->
            <li>
                <a href="{{ route('ventes.index') }}" class="flex items-center font-bold p-3 rounded-lg transition-colors duration-200 hover:bg-accent {{ request()->routeIs('ventes.*') ? 'bg-accent' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span>Gestion des ventes</span>
                </a>
            </li>

            <!-- Gestion des utilisateurs (Admin seulement) -->
            @auth
                @if(Auth::user()->isAdmin())
                <li>
                    <a href="{{ route('users.index') }}" class="flex font-bold text-[0.9rem] items-center p-3 rounded-lg transition-colors duration-200 hover:bg-accent {{ request()->routeIs('users.*') ? 'bg-accent' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                        </svg>
                        <span>Gestion des utilisateurs</span>
                    </a>
                </li>
                @endif
            @endauth
        </ul>

        <!-- Section utilisateur en bas -->
<div class="absolute bottom-0 left-0 w-full p-4 border-t border-primary-700">
    <div class="flex items-center space-x-3">
        <div class="relative">
            @if (Auth::user()->photo_url)
                <img src="{{ Auth::user()->photo_url }}" alt="Photo de profil" class="w-10 h-10 rounded-full object-cover">
            @else
                <!-- Icône par défaut -->
                <div class="w-10 h-10 rounded-full bg-accent flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            @endif
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium truncate text-white">{{ Auth::user()->name }}</p>
            <p class="text-xs text-primary-300 truncate">{{ Auth::user()->email }}</p>
        </div>
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="text-primary-300 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                </svg>
            </button>
            
            <div x-show="open" @click.away="open = false" class="absolute right-0 bottom-10 mb-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" x-cloak>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 ">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-800 hover:text-white">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
    </nav>
</aside>