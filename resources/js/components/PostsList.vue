<template>
    <div class="container mt-5">
        <div v-for="post in posts" :key="post.id">
            <Post :post="post" />
        </div>
    </div>
</template>

<script>
import Post from './Post.vue'
import { usePostStore } from '../stores/postStore'
import { mapState, mapActions } from "pinia"

export default {
    components: { Post },

    computed: {
        ...mapState(usePostStore, ['posts'])
    },

    methods: {
        ...mapActions(usePostStore, ['storePosts'])
    },

    created() {
        axios.get("http://localhost:8000/api/posts")
            .then(response => this.storePosts(response.data))
            .catch(error => console.log(error))
    }
}
</script>