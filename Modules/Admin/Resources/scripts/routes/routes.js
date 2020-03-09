import store from "@/store";


import { Login, Dashboard, E404 } from "@/pages";

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

export default routes;