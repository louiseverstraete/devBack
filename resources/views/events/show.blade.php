@extends('layouts.app')
@section('content')
@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4 text-heading">{{ $event->title }}</h1>
    <p class="text-body mb-6">{{ $event->description }}</p>
    <p class="text-body mb-6">Date: {{ $event->event_date }}</p>
    <p class="text-body mb-6 capitalize">Visibility: {{ $event->visibility }}</p>
    <a href="{{ route('events.index') }}" class="inline-flex items-center text-white rounded-xl bg-blue-950 box-border border border-transparent hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Back to Events</a>
</div>

@if(\Carbon\Carbon::parse($event->event_date)->isFuture())
    
    <form action="{{ route('events.register', $event) }}" method="POST" class="flex flex-col mx-auto p-6 mt-6 items-center">
        @csrf
        <h2 class="text-2xl font-bold mb-4 text-heading">Inscription à l'événement</h2>
        <div class="flex flex-col items-center gap-4">
            <input type="hidden" name="event_id" value="{{ $event->event_id }}">
            <input type="email" name="email" required placeholder="Votre adresse email" class="p-2 border border-gray-300 rounded-lg w-full max-w-md">
            <input type="text" name="name" required placeholder="Votre nom" class="p-2 border border-gray-300 rounded-lg w-full max-w-md">
            <input type="text" name="participant_dietary" placeholder="Préférences alimentaires" class="p-2 border border-gray-300 rounded-lg w-full max-w-md">
        </div>
        
        <div class="flex flex-col items-center mt-6">
            <div class="wrap mt-3 flex gap-5 items-center">
                <h2>Ajouter des participants</h2>
                <button type="button" id="add-participants-btn" class="text-white rounded-xl bg-gray-500 box-border border border-transparent hover:bg-gray-400 shadow-xs font-medium leading-5 rounded-base text-sm px-1.5 focus:outline-none">+</button>
            </div>
            <div id="additional-participants" class="flex flex-col items-center mt-4"></div>
        </div>
        <button type="submit" class="mt-4 inline-flex items-center text-white rounded-xl bg-green-600 box-border border border-transparent hover:bg-green-500 focus:ring-4 focus:ring-green-300 shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">S'inscrire à l'événement</button>
    </form>

@else
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold mb-4 text-heading">
                    Avis des participants
                </h2>
                <p class="text-xl text-gray-600">
                    Découvrez ce qu'ils pensent de nos événements
                </p>
            </div>

            @if($reviews->isEmpty())
                <p class="text-center text-gray-500">Aucun avis pour le moment. Soyez le premier !</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                    @foreach($reviews as $review)
                        <div class="bg-gradient-to-br from-white to-purple-50 rounded-2xl shadow-lg p-6 border border-purple-100 hover:shadow-xl transition">
                            
                            <div class="flex gap-1 mb-4">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>

                            <p class="text-gray-700 mb-4 italic line-clamp-4">
                                "{{ $review->message }}"
                            </p>

                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr($review->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $review->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="text-center">
                <button 
                    onclick="openReviewModal()"
                    class="mt-4 inline-flex items-center text-white rounded-xl bg-green-600 box-border border border-transparent hover:bg-green-500 focus:ring-4 focus:ring-green-300 shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none"
                >
                    Laisser mon avis
                </button>
            </div>

        </div>
    </div>

    <div id="reviewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 transform transition-all">
            
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Laisser un avis</h3>
                <button onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('reviews.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="review_name" class="block text-sm font-bold text-gray-700 mb-2">
                        Votre nom <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="review_name" 
                        name="name" 
                        required
                        value="{{ old('name') }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition"
                        placeholder="Jean Dupont"
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Votre note <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                <svg class="w-10 h-10 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-300 transition" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </label>
                        @endfor
                    </div>
                    @error('rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="review_message" class="block text-sm font-bold text-gray-700 mb-2">
                        Votre avis <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="review_message" 
                        name="message" 
                        required
                        rows="4"
                        maxlength="500"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition resize-none"
                        placeholder="Partagez votre expérience..."
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Maximum 500 caractères</p>
                </div>

                <div class="flex gap-3">
                    <button 
                        type="button"
                        onclick="closeReviewModal()"
                        class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition"
                    >
                        Annuler
                    </button>
                    <button 
                        type="submit"
                        class="flex-1 px-6 py-3 rounded-xl bg-green-600 box-border border border-transparent hover:bg-green-500 focus:ring-4 focus:ring-green-300 leading-5 focus:outline-none transition"
                    >
                        Publier
                    </button>
                </div>

                <p class="text-xs text-gray-500 text-center mt-4">
                    Votre avis sera publié après modération
                </p>
            </form>
        </div>
    </div>

    <script>
    function openReviewModal() {
        document.getElementById('reviewModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeReviewModal();
    });

    document.getElementById('reviewModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeReviewModal();
    });
    </script>
@endif

@endsection