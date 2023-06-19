import { defineStore } from 'pinia'

export const usePostStore = defineStore({
    // id requis pour connecter le store aux devtools
    id: 'postStore',

    state: () => {
        return {
            posts: []
        }
    },

    actions: { // stocker les infos de l'utilisateur dans le store
        // appelée lors de la connexion et lors de la modif des infos
        storePosts(posts) {
            this.posts = posts
        },
    },

    persist: false, // activation du plugin de persistance
})