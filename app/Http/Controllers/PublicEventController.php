<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationConfirmed;
use App\Models\Event;
use App\Models\Guest;
use App\Models\Registration;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PublicEventController extends Controller
{
    public function index()
    {
        $events = Event::query()->where('visibility', 'PUBLIC')->where('event_date', '>=', now())->orderBy('event_date')->paginate(6);
        

        $pastEvents = Event::where('event_date', '<', now())->orderBy('event_date', 'desc')->paginate(6);

    return view('events.index', compact('events', 'pastEvents'));
}

    public function show(Event $event)
{
    $reviews = Review::approved()
            ->latest()
            ->limit(6)
            ->get();
    return view('events.show', compact('event', 'reviews'));
}

public function login()
{
    return view('admin.login');
}

public function loginSubmit(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (auth()->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }
    return back()->withErrors([
        'email' => 'Les informations de connexion sont incorrectes.',
    ]);
}

    public function register(Request $request, Event $event)
{
    
    $registration = Registration::where('event_id', $event->event_id)
        ->where('contact_email', $request->input('email'))
        ->first();
        

    if ($registration) {
        return redirect()->back()->with('error', 'Vous êtes déjà inscrit à cet événement.');
    }

    $validated = $request->validate([
        'name'                => 'required|string|max:255',
        'email'               => 'required|email|max:255',
        'participant_dietary' => 'nullable|string|max:500',
    ]);

    $registration = Registration::create([
        'event_id'      => $event->event_id,
        'contact_name'  => $validated['name'],
        'contact_email' => $validated['email'],
        'status'        => 'CONFIRMED',
    ]);
    
    $primaryGuest = Guest::create([
        'full_name'       => $validated['name'],
        'dietary_notes'   => $validated['participant_dietary'] ?? null,
        'registration_id' => $registration->registration_id,
        'is_primary'      => 1,
    ]);

    $guestNames    = $request->input('guest_name', []);
    $guestDietaries = $request->input('guest_dietary', []);

    foreach ($guestNames as $index => $guestName) {
        if (!empty($guestName)) {
            Guest::create([
                'full_name'       => $guestName,
                'dietary_notes'   => $guestDietaries[$index] ?? null,
                'registration_id' => $registration->registration_id,
                'is_primary'      => 0,
                'invited_by_id'   => $primaryGuest->id,
            ]);
        }
    }

    Mail::to("louuvrste@gmail.com")->send(new RegistrationConfirmed($registration));
    return redirect()->back()->with('success', 'Vous êtes bien inscrit à cet événement !');
}


    public function cancel(Registration $registration)
{
    $registration->update(['status' => 'CANCELED']);

    return view('events.show', ['event' => $registration->event, 'message' => 'Votre réservation a bien été annulée.']);
}

    public function storeReview(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'message' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ], [
            'name.required' => 'Veuillez indiquer votre nom.',
            'message.required' => 'Veuillez laisser un message.',
            'rating.required' => 'Veuillez attribuer une note.',
            'rating.min' => 'La note doit être entre 1 et 5.',
            'rating.max' => 'La note doit être entre 1 et 5.',
        ]);

        Review::create([
            'name' => $validated['name'],
            'message' => $validated['message'],
            'rating' => $validated['rating'],
            'approved' => false, // En attente de modération
        ]);

        return redirect()->back()->with('success', 'Merci pour votre avis ! Il sera publié après modération.');
    }

}
