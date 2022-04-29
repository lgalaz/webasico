<template>
    <div>
        <b-form @submit.prevent="onSubmit">
            <b-form-group id="mainGroup" label="Nombre del sitio:">
                <b-form-input
                    id="name"
                    v-model="currentWebsite.name"
                    required
                    placeholder="Ingresa un nombre"
                ></b-form-input>
            </b-form-group>
            <b-button type="submit" variant="primary">Actualizar</b-button>
        </b-form>
    </div>
</template>

<script>
    export default {
        props: {
            website: {type: Object, required: true}
        },

        data() {
            return {
                currentWebsite: {
                    name: '',
                },
            }
        },

        mounted() {
            this.currentWebsite = Object.assign({}, this.website);
        },

        methods: {
            onSubmit(evt) {
                const url = this.route('api.website.update', [this.website.account_id, this.website.website_id]);

                window.axios.put(url, this.currentWebsite)
                    .then(response => {
                        this.$emit('websiteUpdated');

                        window.wb.flash('Website Updated.');
                    })
                    .catch(error => {
                        window.wb.flashDanger(error.response);
                    });
            }
        }
    }
</script>
