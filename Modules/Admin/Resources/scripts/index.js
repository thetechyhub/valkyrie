import _ from 'lodash';
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require("popper.js").default;
    window.$ = window.jQuery = require("jquery");

    require("bootstrap");
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.axios.defaults.headers.common["client-id"] = process.env.MIX_ADMIN_CLIENT_ID;
window.axios.defaults.headers.common["client-secret"] = process.env.MIX_ADMIN_CLIENT_SECRET;

/**
 * 
 * This file is used as the entry point for your application bundle
 * Vue, Vuex and Vue Router are initiated in this file.
 * 
 */

import Vue from "vue";
import app from '@/app';
import store from "@/store";
import router from "@/routes";

import PrimaryLayout from "@pages/Layout/PrimaryLayout";
import SecondaryLayout from "@pages/Layout/SecondaryLayout";
import ErrorLayout from "@pages/Layout/ErrorLayout";

Vue.component("main-layout", PrimaryLayout);
Vue.component("secondary-layout", SecondaryLayout);
Vue.component("error-layout", ErrorLayout);

new Vue({
	el: "#app",
	store: store,
	router: router,
	render: h => h(app)
});