import './bootstrap';

// on importe Bootstrap
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"

// On importe createApp
import { createApp } from "vue"

// On importe le composant principal App
import App from "./App.vue"

// On importe le routeur
import router from './router'

//on importe pinia et le plugin de persistance du state
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

//on les initialise
const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

// On monte l'application Vue sur l'élément #app
// on inclut le routeur et le store dans l'application
createApp(App).use(router).use(pinia).mount("#app")

