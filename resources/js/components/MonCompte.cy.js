import MonCompte from './MonCompte.vue'
import { useUserStore } from "../stores/userStore"

// ******************************** test d'intégration composant MonCompte.vue *********************************

describe('<MonCompte />', () => {
  it('connexion utilisateur, puis modification email et vérification du changement dans le state', () => {

    // on instancie le userstore
    const userStore = useUserStore();

    // montage du composant
    cy.mount(MonCompte)

    // test affichage h1
    cy.get('h1').should('have.text', 'Mon Compte')  // syntaxe 1

    // connexion utilisateur partie 1 : requête cookie CSRF 
    cy.request('http://localhost:8000/sanctum/csrf-cookie').as('csrfcookie')

    cy.get('@csrfcookie').should((response) => {
      expect(response.status).to.eq(204)
    })

    // connexion utilisateur partie 2 : login
    cy.request('POST', 'http://localhost:8000/api/login/',
      { email: 'admin@reseausocial.fr', password: 'Azerty88@' })
      .then(
        (response) => {
          // response.body is automatically serialized into JSON
          expect(response.status).to.eq(200)
          expect(response.body[0]).to.have.property('email', 'admin@reseausocial.fr')

          userStore.storeUserData(response.body[0]) // stockage des infos user de la réponse dans le store
          expect(userStore.email).to.equal("admin@reseausocial.fr")  // vérification que le store contient l'email 

          // vérif que l'input email contient bien celui de l'utilisateur
          cy.get('input[name=email]')
            .should('have.value', 'admin@reseausocial.fr')

          // remplacement email dans input + vérification
          cy.get('input[name=email]')
            .clear()
            .type('test@test.fr')
            .should('have.value', 'test@test.fr')

            cy.get('button[type=submit]').first().click()

          // vérification que le store aussi contient le nouvel email saisi => coince tjrs
          expect(userStore.email).to.equal("test@test.fr")
        }
      )

  })
})


          // cy.get("h1").invoke("text").should("eq", "Mon Compte"); // syntaxe 2 

// *************** instancier pinia ***************
// beforeEach(() => {
//   Cypress.config("defaultCommandTimeout", 500);

//   const spy = cy.spy();

//   createTestingPinia({
//     createSpy: () => spy,
//   });

//   // one way:
//   const userStore = useUserStore() // on initialise le userStore (il sera accessible via cette variable)

//   // // another way with the same error:
//   // store = useNavStore(createTestingPinia({
//   //   createSpy: () => spy,
//   // }));

//   cy.mount(MonCompte, {
//     global: {
//       plugins: [userStore],
//     },
//   });
// });