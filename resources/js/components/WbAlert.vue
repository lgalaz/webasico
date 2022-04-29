<template>
    <div v-show="show">
        <b-alert
            :show="showAlert"
            :variant="currentVariant"
            dismissible
            @dismissed="dismiss"
            @dismiss-count-down="(countDown) => this.dismissCountDown = countDown"
        >
            <slot name="header" v-if="header">{{ header }}</slot>
            <slot></slot>
            <ul class="messages">
                <li v-for="msg in currentMessages" :key="msg">
                    {{ msg }}
                </li>
            </ul>
            <slot name="footer" v-if="footer"></slot>
        </b-alert>
    </div>
</template>

<script>
    export default {
        props: {
            dismissSeconds: {type: Number, default: 5},
            isCountdownDismissable: {type: Boolean, default: true},
            messages: {type: Array, default: () => []},
            variant: {
                type: String,
                default: 'success',
                validator: function (value) {
                    const bootstrapVariants = ['success', 'warning', 'danger'];
                    return bootstrapVariants.indexOf(value) !== -1;
                }
            },
        },

        data() {
            return {
                currentVariant: 'success',
                currentMessages: [],
                dismissCountDown: 0,
                footer: '',
                header: '',
                show: false,
            }
        },

        computed: {
            showAlert() {
                if (this.show && this.isCountdownDismissable) {
                    return this.dismissCountDown;
                }

                return this.show;
            },
        },

        created() {
            window.wb.events.$on('flash', data => this.flash(data));

            this.currentMessages = this.messages;
            this.currentVariant = this.variant;
        },

        methods: {
            countDownChanged(dismissCountDown) {
                this.dismissCountDown = dismissCountDown;
            },
            dismiss() {
                this.dismissCountDown=0;
                this.show = false;
                this.currentMessages = [];
                this.currentVariant = 'success';
            },
            flash(data) {
                if (data.header) {
                    this.header = data.header;
                }

                if (data.messages) {
                    this.currentMessages = data.messages;
                }

                if (data.variant) {
                    this.currentVariant = data.variant;
                }

                this.showMessages();
            },
            showMessages() {
                this.dismissCountDown = this.dismissSeconds;
                this.show = true;
            },
        }
    };
</script>
