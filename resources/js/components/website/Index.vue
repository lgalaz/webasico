<template>
    <div>
        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-show="showIndex">
            <b-form-group id="mainGroup" label="Nombre del sitio:">
                <b-form-input
                    id="name"
                    v-model="website.name"
                    required
                    placeholder="Ingresa un nombre"
                ></b-form-input>
            </b-form-group>
            <b-button type="submit" variant="primary">Guardar</b-button>
            <div class="mt-5">
                <b-table
                    :fields="websiteFields"
                    :items="currentWebsites"
                    small
                    responsive
                    fixed
                    striped
                    bordered
                >
                    <template v-slot:cell(name)="data">
                        <div>{{data.item.name}}</div>
                    </template>
                    <template v-slot:cell()="data">
                        <div>
                            <b-button 
                                @click="editWebsite(data.item)" 
                                size="sm"
                                class="mb-2"
                            >
                               <b-icon icon="pencil-fill" aria-hidden="true"></b-icon> Editar
                            </b-button>
                            <b-button 
                                @click="configureWebsite(data.item)" 
                                size="sm" 
                                class="mb-2"
                            >
                               <b-icon icon="columns-gap" aria-hidden="true"></b-icon> Configurar
                            </b-button>
                            <b-button 
                                @click="removeWebsite(data.item.website_id)" 
                                size="sm" 
                                class="mb-2"
                            >
                               <b-icon icon="trash-fill" aria-hidden="true"></b-icon> Borrar
                            </b-button>
                        </div>
                    </template>
                </b-table>
            </div>
        </b-form>
        <edit-website
            v-if="selectedWebsite && showEdit"
            :website="selectedWebsite"
            @websiteUpdated="websiteUpdated"
        />
    </div>
</template>

<script>
    import EditWebsite from './Edit';

    export default {
        components: {EditWebsite},

        props: {
            account: {type: Object, required: true},
            websites: {type: Array, required: true},
        },

        data() {
            return {
                website: {
                    name: '',
                },
                currentWebsites: [],
                websiteFields:[],
                showIndex: true,
                showEdit: false,
                selectedWebsite: null,
            }
        },

        mounted() {
            this.currentWebsites = this.websites;

            this.websiteFields =  [
                {
                    key: 'name',
                    sortable: false,
                    label: 'Name'
                },
                {
                    key: 'edit',
                    sortable: false,
                    label: ''
                },
            ]
        },

        methods: {
            configureWebsite(website) {
                this.selectedWebsite = website;
                const params = [this.account.account_id, website.website_id];
                window.location = this.route('website.configure', params);
            },
            editWebsite(website) {
                this.selectedWebsite = website;
                this.showIndex = false;
                this.showEdit = true;
            },
            init() {
                this.website.name = '';

                // Trick to reset/clear native browser form validation state
                this.showIndex = false;
                this.$nextTick(() => {
                    this.showIndex = true;
                });
            },
            getWebsite() {
                window.axios.get(this.route('api.website.index', [this.account.account_id]))
                    .then(response => this.currentWebsites = response.data);
            },
            onSubmit(evt) {
                window.axios.post(this.route('api.website.store', [this.account.account_id]), this.website)
                    .then(response => {
                        this.init();

                        this.currentWebsites.push(response.data.website);

                        window.wb.flash('Website Saved.');
                    })
                    .catch(error => {
                        window.wb.flashDanger(error.response);
                    });
            },
            onReset(evt) {
                this.init();
            },
            removeWebsite(websiteId){
                if (!window.confirm("Do you really want to delete this site?")) {
                    return;
                }
                
                window.axios.delete(this.route('api.website.destroy', [this.account.account_id, websiteId]))
                    .then(response => {
                        this.init();

                        this.currentWebsites = this.currentWebsites.filter((website) => {
                            return website.website_id !== websiteId;
                        });

                        window.wb.flash('Website Deleted.');
                    })
                    .catch(error => {
                        window.wb.flashDanger(error.response);
                    });
            },
            websiteUpdated() {
                this.getWebsite();
                this.showEdit = false;
                this.showIndex = true;
            }
        }
    }
</script>
