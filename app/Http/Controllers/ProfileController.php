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

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'current_password' => $user->force_password_change ? 'required' : 'nullable',
            'new_password' => [$user->force_password_change ? 'required' : 'nullable', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ], [
            'new_password.required' => 'Le nouveau mot de passe est obligatoire pour la première connexion.',
            'photo.image' => 'Le fichier doit être une image valide.',
            'photo.mimes' => 'L\'image doit être de type: jpeg, png, jpg, gif ou webp.',
            'photo.max' => 'L\'image ne doit pas dépasser 2MB.',
        ]);

        // Mise à jour des informations de base
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;

        // Gestion de la suppression de photo
        if ($request->has('delete_photo') && $request->delete_photo == '1') {
            if ($user->photo) {
                $oldPhotoPath = 'images/users/' . $user->photo;
                if (Storage::exists($oldPhotoPath)) {
                    Storage::delete($oldPhotoPath);
                }
                $user->photo = null;
            }
        }

        // Gestion de la photo
        if ($request->hasFile('photo')) {
            try {
                // Supprimer l'ancienne photo si elle existe
                if ($user->photo) {
                    $oldPhotoPath = 'images/users/' . $user->photo;
                    if (Storage::exists($oldPhotoPath)) {
                        Storage::delete($oldPhotoPath);
                    }
                }

                $photo = $request->file('photo');
                // Générer un nom unique pour l'image
                $photoName = 'user_' . $user->id . '_' . time() . '.' . $photo->getClientOriginalExtension();

                // Stocker l'image dans le dossier storage/images/users (comme pour les plats)
                $photo->storeAs('images/users', $photoName);

                // Enregistrer le nom du fichier dans la base de données
                $user->photo = $photoName;

            } catch (\Exception $e) {
                return back()->withErrors(['photo' => 'Erreur lors du téléchargement de l\'image: ' . $e->getMessage()]);
            }
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

        // Supprimer la photo de profil si elle existe
        if ($user->photo) {
            $photoPath = 'images/users/' . $user->photo;
            if (Storage::exists($photoPath)) {
                Storage::delete($photoPath);
            }
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
