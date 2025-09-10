<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-primary text-white transform transition-transform duration-200 ease-in-out md:translate-x-0 -translate-x-full" 
        :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }" 
        x-cloak>
    <!-- Logo et nom du projet -->
    <div class="flex items-center justify-between p-4 border-b border-blue-800">
        <div class="flex items-center space-x-3">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
           {{-- < x-logo/> --}}
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
                <a href="{{ route('dashboard') }}" class="flex items-center p-3 rounded-lg transition-colors duration-200 hover:bg-blue-800 {{ request()->routeIs('dashboard') ? 'bg-blue-800' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Gestion des plats -->
            <li>
                <a href="{{ route('plat.index') }}" class="flex items-center p-3 rounded-lg transition-colors duration-200 hover:bg-blue-800 {{ request()->routeIs('plats.*') ? 'bg-blue-800' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.5 1.5 0 013 15.546V5a2 2 0 012-2h14a2 2 0 012 2v10.546z"></path>
                    </svg>
                    <span>Gestion des plats</span>
                </a>
            </li>

            <!-- Gestion des clients -->
            <li>
                <a href="{{ route('client.index') }}" class="flex items-center p-3 rounded-lg transition-colors duration-200 hover:bg-blue-800 {{ request()->routeIs('clients.*') ? 'bg-blue-800' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Gestion des clients</span>
                </a>
            </li>

            <!-- Gestion des ventes -->
            <li>
                <a href="{{ route('vente.index') }}" class="flex items-center p-3 rounded-lg transition-colors duration-200 hover:bg-blue-800 {{ request()->routeIs('ventes.*') ? 'bg-blue-800' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span>Gestion des ventes</span>
                </a>
            </li>

            <!-- Statistiques -->
            <li>
                <a href="#" class="flex items-center p-3 rounded-lg transition-colors duration-200 hover:bg-blue-800">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Statistiques</span>
                </a>
            </li>
        </ul>

        <!-- Section utilisateur en bas -->
        <div class="absolute bottom-0 left-0 w-full p-4 border-t border-blue-800">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-blue-700 flex items-center justify-center">
                    <span class="text-sm font-medium">AD</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate">Admin User</p>
                    <p class="text-xs text-blue-300 truncate">admin@chc.edu</p>
                </div>
                <a href="#" class="text-blue-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </a>
            </div>
        </div>
    </nav>
</aside>

<!-- Overlay pour mobile -->
<div class="fixed inset-0 z-40 bg-black bg-opacity-50 transition-opacity duration-200 ease-in-out md:hidden" 
     :class="{ 'opacity-100 pointer-events-auto': sidebarOpen, 'opacity-0 pointer-events-none': !sidebarOpen }" 
     @click="sidebarOpen = false" x-cloak>
</div>