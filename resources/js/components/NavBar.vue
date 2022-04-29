<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="info">
            <b-navbar-brand href="home">{{ this.$store.state.appName }}</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-item :href="route('website.index', this.user.account.account_id)">Websites</b-nav-item>
                </b-navbar-nav>
                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto" v-if="this.$store.getters.isAuthenticated">
                    <b-nav-item-dropdown right no-caret lazy>
                        <!-- Using 'button-content' slot -->
                        <template v-slot:button-content class="mr-1">
                            <b-avatar variant="dark" text="LG" class="mr-1"></b-avatar>
                        </template>
                        <b-dropdown-item :href="this.route('profile.show')">Profile</b-dropdown-item>
                        <b-dropdown-item-button @click="logout">Sign out</b-dropdown-item-button>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
    import { BAvatar } from 'bootstrap-vue';
    import { BNavbar } from 'bootstrap-vue';

    export default {
        components: { BAvatar, BNavbar },

        computed: {
            user() {
                return this.$store.getters.user;
            }
        },

        methods: {
            logout() {
                try {
                    window.axios.post(this.route('logout'))
                        .then(() => document.location = this.route('welcome'));
                } catch (err) {
                    console.log(err);
                }
            }
        }
    };
</script>
