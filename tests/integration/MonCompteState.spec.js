import MonCompte from "../../resources/js/components/user/MonCompte.vue" // import du composant Mon Compte
import { createTestingPinia } from '@pinia/testing'  // import de pinia (version pour tests unitaires)
import { shallowMount, RouterLinkStub } from '@vue/test-utils' // import de shallowMount (pour instancier le composant
// sans ses composants enfants) + RouterLinkStub (pour que le bouton router-link soit reconnu durant le test)
import { useUserStore } from "../../resources/js/stores/userStore"

const sendData = jest.spyOn(MonCompte.methods, 'sendData') // on initialise la fonction sendData pour tester son appel

const wrapper = shallowMount(MonCompte, {  // on instancie le composant avec shallowMount
    global: {
        plugins: [createTestingPinia()],  // on initialise le state Pinia
        stubs: {
            'router-link': RouterLinkStub, // on inclut routerlinkStub pour éviter une erreur sur router-link
        }
    }
})

const userStore = useUserStore() // on initialise le userStore (il sera accessible via cette variable)

describe("composant MonCompte.vue : modification de l_\'email et vérification de son stockage dans le state", () => {

    it('affichage du titre de la page', () => {
        const title = wrapper.get('h1')
        expect(title.text()).toBe('Mon compte')
    })

    // it('modification de l_\'email dans le formulaire', async () => {
    //     const email = wrapper.find("#email")
    //     email.setValue('utilisateur@test.fr')
    //     expect(email.element.value).toBe("utilisateur@test.fr")
    // })

    // it('vérification que le nouveau mail est bien stocké dans le store', async () => {
    //     expect(userStore.email).toEqual("utilisateur@test.fr")
    // })

    // it('clic sur bouton validation du formulaire : fonction sendData déclenchée', async () => {
    //     await wrapper.find('form').trigger('submit.prevent');
    //     expect(sendData).toBeCalled();
    // })
})
