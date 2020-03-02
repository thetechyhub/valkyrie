window._ = require("lodash");
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


/**
 * 
 * This file is used as the entry point for your application bundle
 * Vue, Vuex and Vue Router are initiated in this file.
 * 
 */

import Vue from "vue";
import App from './App.vue';
import store from "./store";
import routes from "./routes";

import PrimaryLayout from "component/Layout/PrimaryLayout";
import SecondaryLayout from "component/Layout/SecondaryLayout";
import ErrorLayout from "component/Layout/ErrorLayout";

Vue.component("main-layout", PrimaryLayout);
Vue.component("secondary-layout", SecondaryLayout);
Vue.component("error-layout", ErrorLayout);

const app = new Vue({
	el: "#app",
	store: store,
	router: routes,
	render: h => h(App)
});

 