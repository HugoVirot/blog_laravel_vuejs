// Import the Component to mount
import HelloWorld from "./HelloWorld.vue";

describe("Vue Component test", () => {
    it("HelloWorld vue component test", () => {
        // mount the Component by passing required properties to the component
        cy.mount(HelloWorld, { props: { msg: "Hello Vitest" } });
        cy.get("a[href='https://vitejs.dev/']").invoke("text").should("eq", "Vite");
    });
});