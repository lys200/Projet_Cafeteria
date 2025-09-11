@extends('pages.include.base')
@section('titre')
    Plats
@endsection
@section('titre_page')
    Gestion des Plats
@endsection





@section('content')

    @if(session('success'))
        <script>alert("{{ session('success') }}");</script>
    @endif

    <a href="{{ route('plat.create') }}">Ajouter un plat</a>

    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            {{-- <h1 class="text-3xl font-bold text-primary-600 mb-2">Bienvenue à la Cafet CHC</h1> --}}
            <p class="text-gray-600">Découvrez nos délicieux plats du jour</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($plats as $plat)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-200 hover:border-2 hover:border-yellow-700" >
                    <div class="h-48 bg-secondary overflow-hidden">
                        @if($plat->image)
                            <img src="{{ asset('storage/images/plats/' . $plat->image) }}" alt="{{ $plat->nom_plat }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.5 1.5 0 013 15.546V5a2 2 0 012-2h14a2 2 0 012 2v10.546z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $plat->nom_plat }}</h3>
                        <p class="text-gray-600 mb-2">{{ $plat->description }}</p>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-primary-600 font-bold">{{ number_format($plat->prix, 0, ',', ' ') }} HTG</span>
                            <span
                                class="bg-secondary-100 text-secondary-800 text-xs px-2 py-1 rounded-full">{{ $plat->cuisson }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Quantité: {{ $plat->quantite }}</span>
                            @auth
                                @if(Auth::user()->isAdmin())
                                    <div class="flex space-x-2">
                                        {{-- <a href="{{route('plat.destroy', $plat->id)}}">Supprimer</a> --}}
                                        <a href="{{ route('plat.edit', $plat->id) }}" class="text-blue-600 hover:text-secondary">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @guest
            <div class="text-center mt-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Rejoignez-nous</h2>
                <p class="text-gray-600 mb-6">Inscrivez-vous pour accéder à toutes les fonctionnalités</p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('login') }}"
                        class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                        Se connecter
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-secondary-500 hover:bg-secondary-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                        S'inscrire
                    </a>
                </div>
            </div>
        @endguest
    </div>
@endsection