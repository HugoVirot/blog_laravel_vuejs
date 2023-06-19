<template>
    <div class="pt-2 text-center">
        <i class="mt-2 mx-auto text-primary fa-5x fa-solid fa-user"></i>
        <h1 class="mt-2 fs-1">Connexion</h1>
    </div>

    <div class="container-fluid p-3 p-lg-5">

        <ValidationErrors :errors="validationErrors" v-if="validationErrors" />
        <div class="row justify-content-center p-2">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-white bg-primary text-center fs-5">Entrez vos informations</div>

                    <div class="card-body bg-info text-white p-5">

                        <form @submit.prevent="logIn">

                            <div class="form-group row m-2">
                                <label for="email" class="col-md-4 col-form-label text-md-right">e-mail</label>

                                <div class="col-md-6">
                                    <input v-model="email" id="email" type="email" class="form-control" name="email"
                                        required autocomplete="email">
                                </div>
                            </div>

                            <div class="form-group row m-2">
                                <label for="password" class="col-md-4 col-form-label text-md-right">mot de passe</label>

                                <div class="col-md-6">
                                    <input v-model="password" id="password" type="password" class="form-control"
                                        name="password" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mt-3 text-center">
                                <div class="col-md-6 offset-md-3">
                                    <button type="submit" class="btn btn-lg px-5 bg-primary rounded-pill text-white">
                                        Valider
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import ValidationErrors from "./ValidationErrors.vue"
import { mapActions, mapState } from 'pinia'
import { useUserStore } from '../stores/userStore'

export default {

    data() {
        return {
            email: "",
            password: "",
            validationErrors: ""
        }
    },

    components: { ValidationErrors },

    methods: {
        ...mapActions(useUserStore, ['storeUserData']),

        logIn() {
            // on initialise la protection CSRF Sanctum via cette route
            axios.get('/sanctum/csrf-cookie')

                .then(() => {
                    // on tente la connexion
                    axios.post('http://localhost:8000/api/login', { email: this.email, password: this.password })

                        .then(response => {
                            // si elle réussit : stockage des données utilisateur reçues dans le localstorage via le userStore
                            this.storeUserData(response.data[0])
                            // redirection vers un composant affichant le message de succès "vous êtes connecté"             
                            this.$router.push('/')
                            // si elle échoue : on affiche la ou les erreurs rencontrée(s)
                            
                        }).catch((error) => {
                            this.validationErrors = error.response.data.errors
                        })

                    // si la requête d'initialisation de la protection CSRF a échoué, on affiche ce message
                }).catch(() => {
                    alert("Problème d'authentification'. Merci de recharger la page. Réessayez plus tard ou contactez l'administrateur si le problème persiste.")
                })
        },
    },
}
</script>
