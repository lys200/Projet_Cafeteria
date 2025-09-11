<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => $user->force_password_change ? 'required' : 'nullable',
            'new_password' => [$user->force_password_change ? 'required' : 'nullable', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ], [
            'new_password.required' => 'Le nouveau mot de passe est obligatoire pour la première connexion.',
        ]);

        // Mise à jour des informations de base
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;

        // Gestion de la photo
        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists('images/users/' . $user->photo)) {
                Storage::disk('public')->delete('images/users/' . $user->photo);
            }

            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->storeAs('public/images/users', $photoName);
            $user->photo = $photoName;
        }

        // Mise à jour du mot de passe
        if ($request->filled('new_password')) {
            if ($user->force_password_change || Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->force_password_change = false; // Désactive le flag
            } else {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect']);
            }
        }

        $user->save();

        $message = 'Profil mis à jour avec succès.';
        if ($user->wasChanged('force_password_change') && !$user->force_password_change) {
            $message .= ' Votre mot de passe a été mis à jour avec succès.';
        }

        return redirect()->route('dashboard')->with('success', $message);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
