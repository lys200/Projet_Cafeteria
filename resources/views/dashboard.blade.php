@extends('pages.include.base')

@section('title', 'Tableau de bord')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Card 1 -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-gray-600">Clients</h2>
                <p class="text-2xl font-bold">150</p>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.5 1.5 0 013 15.546V5a2 2 0 012-2h14a2 2 0 012 2v10.546z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-gray-600">Plats</h2>
                <p class="text-2xl font-bold">25</p>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-gray-600">Ventes Aujourd'hui</h2>
                <p class="text-2xl font-bold">89</p>
            </div>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-gray-600">Revenu Journalier</h2>
                <p class="text-2xl font-bold">25,000 HTG</p>
            </div>
        </div>
    </div>
</div>

<!-- Graphique et autres contenus -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Ventes des 7 derniers jours</h3>
        <!-- Placeholder pour graphique -->
        <div class="h-64 bg-gray-100 rounded flex items-center justify-center">
            <p class="text-gray-500">Graphique des ventes</p>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Plats populaires</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold mr-3">1</div>
                    <div>
                        <p class="font-medium">Poulet Grillée</p>
                        <p class="text-sm text-gray-500">25 ventes</p>
                    </div>
                </div>
                <span class="text-green-600 font-semibold">+15%</span>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 font-bold mr-3">2</div>
                    <div>
                        <p class="font-medium">Spaghetti Bolognaise</p>
                        <p class="text-sm text-gray-500">18 ventes</p>
                    </div>
                </div>
                <span class="text-green-600 font-semibold">+8%</span>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 font-bold mr-3">3</div>
                    <div>
                        <p class="font-medium">Poisson Braisé</p>
                        <p class="text-sm text-gray-500">15 ventes</p>
                    </div>
                </div>
                <span class="text-red-600 font-semibold">-5%</span>
            </div>
        </div>
    </div>
</div>
@endsection