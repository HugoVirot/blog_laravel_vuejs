<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    // middleware sanctum pour exiger soit le token, soit le cookie de session
    // appliqué sur toutes les routes sauf store
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index', 'store');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On récupère tous les posts
        $posts = Comment::all();

        // On retourne les posts en JSON 
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'content' => 'required|min:15|max:3000',
                'tags' => 'required|min:5|max:50',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048'
            ],
        );

        // renvoi d'un ou plusieurs messages d'erreur si champ(s) incorrect(s)
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // sauvegarde commentaire en bdd
        $comment = Comment::create($request->all());

        // sauvegarde de l'image (si envoyée)
        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
        }

        // on retourne le commentaire créé en json avec un code de succès (201)
        return response()->json([$comment, 'Commentaire créé avec succès'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validator = Validator::make(
            $request->all(),
            [
                'content' => 'required|min:15|max:3000',
                'tags' => 'required|min:5|max:50',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048'
            ],
        );

        // renvoi d'un ou plusieurs messages d'erreur si champ(s) incorrect(s)
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // sauvegarde des modifications en bdd
        $comment->update($request->all());

        // sauvegarde de l'image (si envoyée)
        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
        }

        // On retourne la réponse JSON
        return response()->json([$comment, 'Commentaire modifié avec succès']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();
        return response()->json([$comment, 'Commentaire supprimé']);
    }
}
