<template>
    <div class="card text-bg-info mb-3 p-2">

        <div class="row text-center">
            <h4>#{{ comment.tags }}</h4>
        </div>
        <div class="card-header row px-5 bg-light">
            <div class="col-6">
                posté par {{ comment.user.pseudo }}
            </div>
            <div class="col-6 text-end">
                posté le {{ comment.created_at.substring(0,10) }}
            </div>
        </div>

        <div class="card-body text-center">
            <h5 class="card-title"></h5>

            <div v-if="comment.image">
                <img class="w-50" :src="`/images/${comment.image}`" alt="image du message">
            </div>

            <p class="m-4">
                {{ comment.content }}
            </p>

            <div class="row mt-3">
                <!--********************** bouton modifier => mène à la page de modification du message ********************-->
                <div class="col-6 text-center">
                    <button class="btn btn-primary mx-auto">modifier</button>
                </div>
                <!--******************************************** bouton supprimer ******************************************-->
                <div class="col-6 text-center">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    props: ['comment']
}
</script>