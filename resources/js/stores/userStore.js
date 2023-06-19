import { defineStore } from 'pinia'
import axios from 'axios'

export const useUserStore = defineStore({
    // id requis pour connecter le store aux devtools
    id: 'UserStore',

    state: () => {
        return {
            pseudo: "",
            email: "",
            id: "",
            token: "",
            role: "",
            userLoggedIn: false,
        }
    },

    actions: { // stocker les infos de l'utilisateur dans le store
        // appelée lors de la connexion et lors de la modif des infos
        storeUserData(userData) {
            this.pseudo = userData.pseudo
            this.email = userData.email
            this.id = userData.id
            this.role = userData.role

            // si token présent dans userData (= connexion, pas présent si modif infos)
            if (userData.token) {
                // on stocke le token dans le store
                this.token = userData.token
                // on ajoute ce header Authorization pour transmettre le token (créé par l'API) avec chaque requête 
                // (si  l'utilisateur est connecté)
                axios.defaults.headers.common.Authorization = `Bearer ${userData.token}`
                // on définit le statut de l'utilisateur : il est connecté
                this.userLoggedIn = true
            }
        },
    },

    persist: true, // activation du plugin de persistance
})