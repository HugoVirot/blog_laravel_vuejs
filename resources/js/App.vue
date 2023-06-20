<template>
    <Header />
    <main class="my-5 mx-2">

        <!-- si la route est différente de / (racine du site) -->
        <!-- on affiche le template du composant concerné par la route -->
        <div v-if="$route.path !== '/'">
            <router-view v-bind:key="$route.fullPath"></router-view>
        </div>

        <!-- si la route est / => on affiche le code de l'accueil-->
        <div v-else>
            <h1 class="text-center text-primary fw-bold">Blog Laravel VueJS</h1>
            <CreerPost />
            <PostsList />
        </div>
    </main>
    <Footer />
</template>

<script>
import PostsList from './components/PostsList.vue'
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
import CreerPost from './components/CreerPost.vue'

export default {
    components: { Header, PostsList, Footer, CreerPost },
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Source+Code+Pro&display=swap');

h1 {
    font-size: 4.5em;
}

h1,
h2 {
    font-family: 'Source Code Pro', sans-serif
}
</style>