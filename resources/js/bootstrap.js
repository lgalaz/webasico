/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

import { Ziggy } from './ziggy';
import route from 'ziggy';
import pluralize from 'pluralize';

Vue.mixin({
    methods: {
        route: (name, params, absolute) => route(name, params, absolute, Ziggy),
    }
});

Vue.filter('pluralize', function (value, element) {
    let number = 1;

    if(Array.isArray(element)) {
        number = element.length;
    }

    if (Number.isInteger(element)) {
        number = element;
    }

    return pluralize(value, number);
});

/**
 * This is an event bus for vue.js communication.
 */

window.wb = window.wb || {};
window.wb.events = new Vue();

window.wb.flash = (message) => {
    window.wb.events.$emit('flash', {
        header: message,
        variant: 'success'
    });
};

window.wb.flashDanger = (params) => {
    const data = window.wb.parseErrorParams(params);

    window.wb.events.$emit('flash', {
        header: data.message,
        messages: data.errors,
        variant: 'danger'
    });
};

window.wb.parseErrorParams = (params = null) => {
    let data = {errors: [], message: ''};

    if (!params || !params.data) {
        return data;
    }

    if (params.data.message) {
        data.message = params.data.message;
    }

    if (params.data.errors) {
        for (const [key, value] of Object.entries(params.data.errors)) {
            data.errors = data.errors.concat(value);
        }
    }

    return data;
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
