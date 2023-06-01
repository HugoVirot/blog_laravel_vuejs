<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On récupère tous les utilisateurs
        $users = User::all();

        // On retourne les utilisateurs en JSON 
        return response()->json($users);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pseudo' => 'required|min:5|max:20|unique:users',
                'email' => 'required|email|max:50|unique:users',
                'password' => [
                    'required', 'confirmed',
                    Password::min(8) // minimum 8 caractères   
                        ->mixedCase() // au moins 1 minuscule et une majuscule
                        ->letters()  // au moins une lettre
                        ->numbers() // au moins un chiffre
                        ->symbols() // au moins un caractère spécial parmi ! @ # $ % ^ & * ?  
                ],
                'image' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048'
            ],
            // message d'erreur pour mdp trop court (n'est pas présent par défaut)
            [
                'password.min' => 'Votre mot de passe doit faire au moins :min caractères.',
            ]
        );

        // renvoi d'un ou plusieurs messages d'erreur si champ(s) incorrect(s)
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        // sauvegarde utilisateur en bdd
        $user = User::create([
            'pseudo' => $request->pseudo,
            'image' => $request->image,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // sauvegarde de l'image (si envoyée)
        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
        }

        // on retire le mot de passe de l'utilisateur que l'on va renvoyer en json (confidentiel)
        unset($user->password);

        // on retourne l'utilisateur créé en json avec un code de succès (201)
        return response()->json($user, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // on retire le mot de passe de l'utilisateur que l'on va renvoyer en json (confidentiel)
        unset($user->password);

        // on retourne l'utilisateur en json 
        return response()->json($user);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:50',
            'oldPassword' => 'nullable',
            'password' => [
                'nullable', 'confirmed',
                Password::min(8) // minimum 8 caractères   
                    ->mixedCase() // au moins 1 minuscule et une majuscule
                    ->letters()  // au moins une lettre
                    ->numbers() // au moins un chiffre
                    ->symbols() // au moins un caractère spécial     
            ]
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        // On modifie les informations de l'utilisateur
        $user->update([
            'email' => $request->email,
            'image' => $request->image,
        ]);

        // sauvegarde de la nouvelle image (si envoyée)
        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
        }

        // si nouveau mdp choisi (et qui respecte bien sûr les critères de sécurité du validateur)
        if ($request->password) {

            // si ancien mdp fourni ET valide (vérifié via Hash::check), modification validée 
            if ($request->oldPassword && Hash::check($request->oldPassword, User::find($user->id)->password)) {
                // on sauvegarde le nouveau mot de passe hashé
                $user->update([
                    'password' => Hash::make($request->password)
                ]);

                // sinon => on renvoie une erreur
            } else {
                return $this->sendError('Error validation', ['mot de passe actuel non renseigné ou incorrect']);
            }
        }

        // On retourne la réponse JSON avec un code de succès (204 = modification réussie)
        return response()->json($user, 204);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // on supprimer l'utilisateur en base de données
        $user->delete();

        // on retourne la réponse contenant l'utilisateur supprimé
        return response()->json($user);

    }
}