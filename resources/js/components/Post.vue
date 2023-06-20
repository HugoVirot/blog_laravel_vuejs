<template>
    <div class="card text-bg-primary mb-5 p-4">

        <div class="row text-center">
            <h2>#{{ post.tags }}</h2>
        </div>
        <div class="card-header row px-5 bg-info">
            <div class="col-6">
                posté par {{ post.user.pseudo }}
            </div>
            <div class="col-6 text-end">
                posté le {{ post.created_at.substring(0, 10) }}
            </div>
        </div>

        <div class="card-body text-center">
            <h5 class="card-title"></h5>

            <div v-if="post.image">
                <img class="w-75" :src="`/images/${post.image}`" alt="image du message">
            </div>

            <p class="m-4">
                {{ post.content }}
            </p>

            <div class="row mt-3">
                <!--********************** bouton modifier => mène à la page de modification du message ********************-->
                <div class="col-6 text-center">
                    <router-link :to="`modifierpost/${post.id}`">
                        <button class="btn btn-info mx-auto">modifier</button>
                    </router-link>
                </div>
                <!--******************************************** bouton supprimer ******************************************-->
                <div class="col-6 text-center">
                    <button @click="deletePost()" class="btn btn-danger">Supprimer</button>
                </div>
            </div>

        </div>

        <CommentsList :comments="post.comments" />
    </div>
</template>

<script>
import CommentsList from './CommentsList.vue';

export default {
    props: ['post'],
    components: {
        CommentsList
    },
    methods: {

        deletePost() {

            axios.delete("http://localhost:8000/api/posts/" + this.post.id)
                .then(response => {
                    alert("Suppression réussie !")
                    this.$router.push('/')
                })
                .catch(error => {
                    if (error.response.status == "403") {
                        alert("Vous n'avez pas l'autorisation de supprimer ce message !")
                        this.$router.push('/')
                    } else {
                        console.log(error.response)
                    }
                })
        }
    }
}
</script>