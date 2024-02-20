import { createWebHistory, createRouter } from "vue-router";
import App from "./App.vue";
import MonCompte from "./components/MonCompte.vue"
import Profil from "./components/Profil.vue"
import Connexion from "./components/Connexion.vue"
import Inscription from "./components/Inscription.vue"
import Politique from "./components/Politique.vue"
import ModifierPost from "./components/ModifierPost.vue"
import HelloWorld from "./components/HelloWorld.vue"

const routes = [
  {
    path: "/",
    name: "App",
    component: App,
  },
  {
    path: "/inscription",
    component: Inscription,
  },
  {
    path: "/connexion",
    component: Connexion,
  },
  {
    path: "/moncompte",
    component: MonCompte,
  },
  {
    path: "/politique",
    component: Politique,
  },
  {
    path: "/profil/:id",
    component: Profil,
  },
  {
    path: "/modifierpost/:id",
    component: ModifierPost,
  },
  {
    path: "/helloworld",
    component: HelloWorld,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;