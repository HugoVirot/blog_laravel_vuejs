/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;

// implémentation de Sanctum => 2ème méthode : SPA Authentication
// grâce à cette ligne de code, axios envoie automatiquement le cookie de session Laravel à chaque requête
// but => authentifier les requêtes
// cette ligne permet également d'éviter le problème de CORS
window.axios.defaults.withCredentials = true;

// afficher chaque requête en console

window.axios.interceptors.request.use(request => {
  // console.log('Starting Request', JSON.stringify(request, null, 2))
  console.log("request");
  console.log(request);
  return request
})

// afficher chaque réponse en console

window.axios.interceptors.response.use(response => {
  // console.log('Response', JSON.stringify(response, null, 2))
  console.log("response");
  console.log(response);
  return response
})

// intercepter les erreurs 401 et déconnecter l'utilisateur si c'est le cas

window.axios.interceptors.response.use(function (response) {
  return response;
}, function (error) {
  if (401 === error.response.status) {

    alert('Votre session a expiré. Vous allez être déconnecté(e). Merci de vous reconnecter.')

    const userStore = useUserStore()
    userStore.$reset()

    // on redirige vers l'accueil
    this.$router.push('/successmessagehome/Déconnexion réussie')

  } else {
    return Promise.reject(error);
  }
});
