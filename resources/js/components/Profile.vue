<template>
    <div>
        <b-card img-src="https://placeimg.com/200/200/any" img-alt="Card image" img-left class="mb-3">
            <b-card-text>
                        Username: {{ userName }}
            </b-card-text>
        </b-card>

        <account/>
    </div>
</template>

<script>
    import Account from './Account';

    export default {

        components: { Account },

        data() {
            return {
                userName: '',
            }
        },

        created() {
            this.userName = this.$store.getters.user.name;
        }
    };
</script>
