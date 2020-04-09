import store from "@/store";
import { E404 } from "@/pages";

const routes = [
  {
    path: "/login",
    name: "login",
    meta: {
        guest: true
    },
    component: lazyLoadPage(
      import(/* webpackChunkName: "auth" */ "@/pages/Auth/Login")
    )
  },
  {
    path: "/dashboard",
    alias: "/",
    name: "root",
    meta: {
        auth: true
    },
    component: lazyLoadPage(
      import(/* webpackChunkName: "dashboard" */ "@/pages/Dashboard/Dashboard")
    )
  },
  {
    path: "*",
    component: E404
  }
];

export default routes;


function lazyLoadPage(ComponentName) {
  const AsyncHandler = () => ({
    component: ComponentName,
    // A component to use while the component is loading.
    loading: E404,
    // Delay before showing the loading component.
    // Default: 200 (milliseconds).
    delay: 4000,
    // A fallback component in case the timeout is exceeded
    // when loading the component.
    error: E404,
    // Time before giving up trying to load the component.
    // Default: Infinity (milliseconds).
    timeout: 10000
  });

  return AsyncHandler;
}