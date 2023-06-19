<template>
    <div class="container mt-5">
        <p class="fs-4 text-center">{{ comments.length }} commentaire(s) pour ce message</p>
        <div v-for="comment in comments" :key="comment.id">
            <Comment :comment="comment" />
        </div>
    </div>
</template>

<script>
import Comment from './Comment.vue'

export default {
    props: [ "comments" ],
    components: { Comment }
}
</script>