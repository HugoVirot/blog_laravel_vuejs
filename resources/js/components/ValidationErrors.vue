<template>
    <div v-if="validationErrors">
        <ul class="alert alert-danger list-unstyled">
            <li v-for="(value, key, index) in validationErrors">{{ value }}</li>
        </ul>
    </div>`
</template>

<script>
export default {

    props: ['errors'],

    computed: {
        validationErrors() {
            // on récupère les messages d'erreur à l'intérieur de l'objet errors en props
            let errors = Object.values(this.errors);
            errors = errors.flat();
            return errors;
        }
    }
}
</script>
