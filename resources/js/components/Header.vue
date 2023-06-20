<template>

    <header class="sticky-top">

        <div class="container-fluid navbar bg-primary" data-bs-theme="dark">

            <!-- ************************** logo ***********************-->

            <div class="d-flex flex-column mx-auto text-center">
                <router-link to="/">
                    <img id="logo" alt="logo" src="images/logo.png" class="w-25"/>
                </router-link>
                <p class="text-white fs-3">Blog Laravel Vue JS</p>
            </div>

            <div class="mt-3 d-none d-md-block" id="rightstripe"></div>

            <!-- hamburger -->

            <button class="navbar-toggler mt-3 d-md-none my-auto" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <!-- ************************** navbar ***********************-->

        <nav class="navbar navbar-expand-md navbar-light">

            <div class="container-fluid">

                <!-- liens -->

                <div class="collapse navbar-collapse" id="navbarNavDropdown">

                    <div class="navbar-nav container d-md-flex justify-content-around text-center">

                        <router-link to="/" class="navbar-brand">accueil</router-link>

                        <!-- si utilisateur connecté : mon compte / mes lieux, si pas connecté : inscription/connexion -->
                        <span v-if="userLoggedIn" class="d-md-flex justify-content-between">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ pseudo }}
                                </a>
                                <ul class="dropdown-menu ms-5 ms-md-0 ps-5 ps-md-0"
                                    aria-labelledby="navbarDropdownMenuLink">

                                    <li>
                                        <router-link to="/moncompte" class="nav-link">mon compte</router-link>
                                    </li>

                                    <li>
                                        <router-link :to="`/profil/${id}`" class="nav-link">mon profil</router-link>
                                    </li>

                                    <li v-if="role == 'admin'">
                                        <router-link to="/backoffice" class="nav-link">
                                            back-office
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                            <i class="greenIcon fa-solid fa-right-from-bracket my-auto" @click="logOutUser()"></i>
                        </span>

                        <span v-else class="d-md-flex justify-content-center">
                            <router-link to="/inscription" class="nav-link me-md-3 me-lg-5">inscription</router-link>
                            <router-link to="/connexion" class="nav-link">connexion</router-link>
                        </span>

                    </div>
                </div>

            </div>

        </nav>

    </header>

</template>

<script>
import { mapState } from "pinia"
import { useUserStore } from "../stores/userStore";

export default {
    computed: {
        // permet d'accéder aux variables du state précisées dans le tableau ci-dessous
        ...mapState(useUserStore, [
            'userLoggedIn',
            'pseudo',
            'role',
            'id'
        ]),
    },

    methods: {
        logOutUser() {
            // on réinitialise le store 
            const userStore = useUserStore()
            userStore.$reset()

            // on remet à zéro le header Authorization pour ne plus transmettre le token créé par l'API
            axios.defaults.headers.common.Authorization = ''

            // on redirige vers l'accueil
            this.$router.push('/')
        }
    }

}
</script>

<style>
header {
    z-index: 1;
    background-color: aqua;
}
a {
    text-decoration: none;
    color: inherit
}

p {
    font-family: 'Source Code Pro', sans-serif
}

</style>
