@extends('layouts.app')
@section('content')
<h1 class="text-3xl font-bold mt-6 mb-6 text-heading">Événements à venir</h1>
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6">
    @foreach ($events as $event)
        <div class="max-w-sm p-6 border border-default rounded-xl shadow-xs flex flex-col justify-between items-start">
            <h2 class="mb-3 text-2xl font-semibold tracking-tight text-heading leading-8">{{ $event->title }}</h2>
            <p class="text-body mb-6">{{ $event->description }}</p>
            <p class="text-body mb-6">Date: {{ $event->event_date}}</p>
            <!-- <p> @if($event->visibility === 'PUBLIC') Événement public @else Événement privé @endif</p> -->
            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center text-white rounded-xl bg-blue-950 box-border border border-transparent hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">View Details</a>
</div>
    @endforeach
</div>
    <div>
    {{ $events->links() }}
</div>
<h1 class="text-3xl font-bold mt-12 mb-6 text-heading">Événements passés</h1>
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6">
    @foreach ($pastEvents as $pastEvent)
        <div class="max-w-sm p-6 border border-default rounded-xl shadow-xs flex flex-col justify-between items-start">
            <h2 class="mb-3 text-2xl font-semibold tracking-tight text-heading leading-8">{{ $pastEvent->title }}</h2>
            <p class="text-body mb-6">{{ $pastEvent->description }}</p>
            <p class="text-body mb-6">Date: {{ $pastEvent->event_date}}</p>
            <!-- <p> @if($event->visibility === 'PUBLIC') Événement public @else Événement privé @endif</p> -->
            <a href="{{ route('events.show', $pastEvent) }}" class="inline-flex items-center text-white rounded-xl bg-blue-950 box-border border border-transparent hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">View Details</a>
</div>
    @endforeach
</div>
    <div>
    {{ $pastEvents->links() }}
</div>
@endsection