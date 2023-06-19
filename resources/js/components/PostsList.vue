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
import { mapState } from "pinia"

export default {
    components: { Post },

    computed: {
        ...mapState(usePostStore, ['posts'])
    },

    created() {
        axios.get("http://localhost:8000/api/posts")
            .then(response => storePosts(response.data))
            .catch(error => console.log(error))
    }
}
</script>