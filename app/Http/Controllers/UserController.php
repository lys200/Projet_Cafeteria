<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
 use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('pages.users.create');
    }

   

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:user,admin',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ], [
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être une adresse valide.',
            'role.required' => 'Le rôle est obligatoire.',
            'role.in' => 'Le rôle doit être "user" ou "admin".',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'force_password_change' => true, // Force le changement à la première connexion
        ]);

        $message = 'Utilisateur créé avec succès. ';
        $message .= '⚠️ L\'utilisateur devra changer son mot de passe à sa première connexion.';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => $message
            ]);
        }

        return redirect()->route('users.index')->with('success', $message);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function edit(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'bio' => 'nullable|string|max:500',
        ]);

        $user->update($request->only('name', 'email', 'role', 'bio'));

        return response()->json(['success' => 'Utilisateur mis à jour avec succès.']);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json(['error' => 'Vous ne pouvez pas supprimer votre propre compte.'], 403);
        }

        $user->delete();
        return response()->json(['success' => 'Utilisateur supprimé avec succès.']);
    }
}