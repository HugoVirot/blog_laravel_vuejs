<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // middleware sanctum pour exiger une preuve de connexion : soit le token, soit le cookie csrf
    // appliqué sur toutes les routes sauf store (pas besoin d'être connecté pour créer un utilisateur)
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('store');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On récupère tous les utilisateurs
        $users = User::all();

        // On retourne les utilisateurs en JSON 
        return response()->json([
            'status' => true,
            'message' => 'Utilisateurs récupérés avec succès',
            'users' => $users
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {

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

        // on retourne l'utilisateur créé en json avec un code de succès (201)
        return response()->json([
            'status' => true,
            'message' => 'Utilisateur créé avec succès',
            'user' => $user
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // on retourne l'utilisateur en json 
        return response()->json([
            'status' => true,
            'message' => 'Utilisateur récupéré avec succès',
            'user' => $user->load('posts')  // on charge ses posts (pour les afficher sur son profil)
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // policy pour vérifier que l'utilisateur peut modifier le compte
        $this->authorize('update', $user);

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
                return response()->json([
                    'status' => false,
                    'message' => 'mot de passe actuel non renseigné ou incorrect',
                    'user' => $user
                ], 400);
            }
        }

        // On retourne la réponse JSON
        return response()->json([
            'status' => true,
            'message' => 'Utilisateur modifié avec succès',
            'user' => $user
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // policy pour vérifier que l'utilisateur peut supprimer le compte
        $this->authorize('delete', $user);

        // on supprimer l'utilisateur en base de données
        $user->delete();

        // on retourne la réponse contenant l'utilisateur supprimé
        return response()->json([
            'status' => true,
            'message' => 'Utilisateur supprimé',
            'user' => $user
        ]);
    }
}
