<template>
    <div class="pt-2 text-center">
        <i class="mt-2 mx-auto text-primary fa-5x fa-solid fa-user"></i>
        <h2 class="mt-2 fs-1">Poster un message</h2>
    </div>

    <div class="container-fluid p-3 p-lg-5">

        <ValidationErrors :errors="validationErrors" v-if="validationErrors" />
        <div class="row justify-content-center p-2">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-white bg-primary text-center fs-5">A vous de jouer !</div>

                    <div class="card-body bg-info text-white p-5">

                        <form @submit.prevent="sendPost">

                            <!-- contenu du message -->
                            <div class="form-group row m-2">
                                <label for="content" class="col-md-4 col-form-label text-md-right">texte</label>
                                <div class="col-md-6">
                                    <input v-model="content" id="content" type="text" class="form-control" name="content"
                                        required autocomplete="content">
                                </div>
                            </div>

                            <!-- tags du message -->
                            <div class="form-group row m-2">
                                <label for="tags" class="col-md-4 col-form-label text-md-right">tags</label>
                                <div class="col-md-6">
                                    <input v-model="tags" id="tags" type="text" class="form-control" name="tags" required
                                        autocomplete="tags">
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
import { useUserStore } from '../stores/userStore'
import { mapState } from 'pinia'

export default {

    data() {
        return {
            content: "",
            tags: "",
            validationErrors: ""
        }
    },

    computed: {
        ...mapState(useUserStore, ['id'])
    },

    components: { ValidationErrors },

    methods: {

        sendPost() {
                    // on tente la connexion
                    axios.post('http://localhost:8000/api/posts', { content: this.content, tags: this.tags, user_id: this.id })

                        .then(response => {
                            alert("Message créé avec succès !")
                            this.$router.push('/')

                        }).catch((error) => {
                            this.validationErrors = error.response.data.errors
                        })
        },
    },
}
</script>
