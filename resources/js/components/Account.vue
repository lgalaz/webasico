<template>
    <div>
        <b-card>
            <template class="pr-2"  #header>
                <h2 class="mb-0">Cuenta de usuario</h2>
            </template>
            <b-card-body>
                <b-form @submit.prevent="onSubmit">
                    <b-container class="flex-grow-1" fluid>
                        <b-row class="my-1">
                            <b-col sm="3" class="d-flex align-items-start">
                                {{ accountUrl }}
                            </b-col>
                            <b-col sm="1" class="d-flex align-items-center">
                                <label for="name" class="mb-0">Nombre:</label>
                            </b-col>
                            <b-col sm="7">
                                <b-form-input
                                    id="name"
                                    v-model="account.name"
                                    required
                                    placeholder="Ingresa un nombre"
                                ></b-form-input>
                                <b-form-text id="input-live-help">{{nameHelp}}</b-form-text>
                            </b-col>
                            <b-col sm="1">
                                <b-button type="submit" variant="primary">Actualizar</b-button>
                            </b-col>
                        </b-row>
                    </b-container>
                </b-form>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                account: {
                    name: '',
                },
                nameHelp:'Nombre de la cuenta. Solo caracteres alfanuméricos, espacios y guiones.'
            }
        },

        computed: {
            accountUrl() {
                return `${this.account.slug}.${window.location.hostname}`;
            }
        },

        mounted() {
            this.account = this.$store.getters.user.account;
        },

        methods: {
            onSubmit(evt) {
                window.axios.put(this.route('api.account.update', [this.account.account_id]), this.account)
                    .then(response => {
                        const data = response.data.account;
                        this.account.name = data.name;
                        this.account.slug = data.slug;

                        window.wb.flash('Account Updated.');
                    })
                    .catch(error => {
                        window.wb.flashDanger(error.response);
                    });
            },
        }
    }
</script>
