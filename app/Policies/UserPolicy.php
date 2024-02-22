<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{

    // vérification que le user est bien admin
    // si oui => il a le droit de tout faire
    public function before(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $userToUpdate)
    {
        // seul l'utilisateur lui-même peut modifier son profil
        return $user->id == $userToUpdate->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $userToDelete)
    {
        // seul l'utilisateur lui-même peut supprimer son compte
        return $user->id == $userToDelete->id;
    }
}
