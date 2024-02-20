<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Tenter la connexion utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Laravel tente de connecter le user si l'email existe ET si le mdp en clair correspond à celui hashé 
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            // si la connexion fonctionne
            // on récupère l'utilisateur et on charge son rôle
            $authUser = User::find(Auth::user()->id);
            $authUser->load('role');

            // on lui crée un token de session via la fonction createToken
            // le token est hashé en Sha-256 avant d'être enregistré dans la table personnal_access_tokens
            // on le stocke en clair (grâce à plaintexttoken) pour le renvoyer ensuite en json
            $authUser->token = $authUser->createToken('TokenDuUser' . $authUser->id)->plainTextToken;

            // on renvoie la réponse 
            return response()->json([$authUser, 'Vous êtes connecté']);

        } else {
            // si échec de la connexion, on renvoie un message d'erreur
            return response()->json(['Echec de la connexion.', 'errors' => 'L\'utilisateur n\'existe pas ou le mot de passe est incorrect']);
        }
    }
}
