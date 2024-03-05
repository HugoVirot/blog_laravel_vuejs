<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    // middleware sanctum pour exiger une preuve de connexion : soit le token, soit le cookie csrf
    public function __construct()
    {
        //$this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On récupère tous les commentaires
        $comments = Comment::all();

        // On retourne les posts en JSON 
        return response()->json([
            'status' => true,
            'message' => 'Commentaires récupérés avec succès',
            'comments' => $comments
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        // sauvegarde commentaire en bdd
        $comment = Comment::create($request->all());

        // sauvegarde de l'image (si envoyée)
        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $comment->update(['image' => $imageName]);
        }

        // on retourne le commentaire créé en json avec un code de succès (201)
        return response()->json([
            'status' => true,
            'message' => 'Commentaire créé avec succès',
            'comment' => $comment
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        // on retourne le commentaire en json 
        return response()->json([
            'status' => true,
            'message' => 'Commentaire récupéré avec succès',
            'comment' => $comment
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        // policy pour vérifier que l'utilisateur peut modifier le commentaire
        //$this->authorize('update', $comment);

        // sauvegarde des modifications en bdd
        $comment->update($request->all());

        // sauvegarde de l'image (si envoyée)
        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $comment->update(['image' => $imageName]);
        }

        // On retourne la réponse JSON
        return response()->json([
            'status' => true,
            'message' => 'Commentaire modifié avec succès',
            'comment' => $comment
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        // policy pour vérifier que l'utilisateur peut supprimer le commentaire
        //$this->authorize('delete', $comment);

        $comment->delete(); // suppression commentaire via syntaxe Eloquent

        return response()->json([
            'status' => true,
            'message' => 'Commentaire supprimé',
            'comment' => $comment
        ]);
    }
}
