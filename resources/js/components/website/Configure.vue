<template>
    <b-card no-body>
        <b-tabs pills card fill>
            <b-tab title="Settings" active>
                <div class="d-flex justify-content-between">
                    <h2>Settings</h2>
                    <b-button
                        variant="primary"
                        @click="save()"
                    >
                        Save
                    </b-button>
                </div>
                <div>
                    <span>Template:</span>&nbsp;
                    <span>{{currentTemplate}}</span>
                </div>
                <section class="template-container">
                    <b-card
                        :title="template.name"
                        :img-src="template.img_src"
                        :img-alt="template.name"
                        img-top
                        style="max-width: 200px;"
                        class="mb-2"
                        v-for="template in templates"
                        v-bind:key="template.template_id"
                    >
                        <b-card-text>
                            {{ template.description }}
                        </b-card-text>

                        <b-button
                            variant="primary"
                            @click="setCurrentTemplate(template)"
                        >
                            Select
                        </b-button>
                    </b-card>
                </section>
            </b-tab>
            <b-tab title="Posts">
                <h2>Posts</h2>
            </b-tab>
        </b-tabs>
    </b-card>
</template>

<script>
    export default {
        props: {
            website: {type: Object, required: true},
        },
        data() {
            return {
                currentTemplate: '',
                currentSettings: {
                    template_id: 0,
                },
                templates: []
            };
        },
        mounted() {
            window.axios.get(this.route('api.template.index'))
                .then(response => {
                    this.templates = response.data;

                    this.templates.forEach((template) => {
                        if (template.template_id === this.website.template_id) {
                            this.currentTemplate = template.name;
                        }
                    })
                })
                .catch(error => {
                    window.wb.flashDanger(error.response);
                });
        },

        methods: {
            save() {
                const url = this.route('api.website.update', [this.website.account_id, this.website.website_id]);

                window.axios.put(url, this.currentSettings)
                    .then(response => {
                        this.$emit('websiteUpdated');

                        window.wb.flash('Website Updated.');
                    })
                    .catch(error => {
                        window.wb.flashDanger(error.response);
                    });
            },
            setCurrentTemplate(template) {
                this.currentSettings.template_id = template.template_id;
                this.currentTemplate = template.name;
            }
        }
    }
</script>

<style scoped>
    .template-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 10px;
        border: 1px solid darkgray;
        padding: 10px;
    }
</style>
