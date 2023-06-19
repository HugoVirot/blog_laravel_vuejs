<template>
    <div>
        <h1 class="text-center text-primary fw-bold">Profil de {{ user.pseudo }}</h1>
    </div>
    <p>{{ user.posts.length }} messages postés</p>
</template>

<script>

import axios from "axios";

export default {

    data(){
        return{
            user: null
        }
    },

    created() {
        axios.get("http//localhost/api/users/" + this.$route.params.id)
            .then(response => this.user = response.data.data)
            .catch(error => console.log(error.response));
    }
}
</script>
