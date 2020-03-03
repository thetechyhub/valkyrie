import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import { Login, Dashboard, E404 } from "../components";


const routes = [
  {
    path: "/login",
    name: "login",
    meta: {
        guest: true
    },
    component: Login
  },
  {
    path: "/dashboard",
    alias: "/",
    name: "root",
    meta: {
        auth: true
    },
    component: Dashboard
  },
  {
    path: "*",
    component: E404
  }
];

export default new VueRouter({
	mode: "history",
  routes
});

