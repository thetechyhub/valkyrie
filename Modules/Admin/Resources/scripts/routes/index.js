import Vue from 'vue';
import VueMeta from 'vue-meta';
import VueRouter from 'vue-router';
import NProgress from 'nprogress/nprogress';

import store from "@/store";
import routes from "./routes";

Vue.use(VueRouter);
Vue.use(VueMeta, {
  keyName: "meta"
});


const router = new VueRouter({
  routes,
	mode: "history",
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { x: 0, y: 0 }
    }
  }
});


/**
 * Before each route evaluates...
 * 
 */
router.beforeEach((toRoute, fromRoute, next) => {
  
  if (fromRoute.name !== null) {
    NProgress.start();
  }

  const isRouteProtected = toRoute.matched.some((route) => route.meta.auth);
  const isGuestOnlyRoute = toRoute.matched.some(route => route.meta.guest);


  if (!isRouteProtected && !isGuestOnlyRoute) return next();

  if(isRouteProtected){
    return store.dispatch("session/validate").then(status => {
      status ? next() : redirectToLogin();
    });
  }else if(isGuestOnlyRoute){
    if (store.getters['session/check']) return redirectToRoot();

    next();
  }

  function redirectToRoot() {
    // Pass the original route to the root page
    next({ name: 'root'})
  }

  function redirectToLogin() {
    // Pass the original route to the login page
    next({ name: "login"});
  }

});


router.beforeResolve(async (routeTo, routeFrom, next) => {
  try {
    // For each matched route...
    for (const route of routeTo.matched) {
      await new Promise((resolve, reject) => {
        // If a `beforeResolve` hook is defined, call it with
        // the same arguments as the `beforeEnter` hook.
        if (route.meta && route.meta.beforeResolve) {
          route.meta.beforeResolve(routeTo, routeFrom, (...args) => {
            // If the user chose to redirect...
            if (args.length) {
              // If redirecting to the same route we're coming from...
              if (routeFrom.name === args[0].name) {
                // Complete the animation of the route progress bar.
                NProgress.done()
              }
              // Complete the redirect.
              next(...args)
              reject(new Error('Redirected'))
            } else {
              resolve()
            }
          })
        } else {
          // Otherwise, continue resolving the route.
          resolve()
        }
      })
    }
    // If a `beforeResolve` hook chose to redirect, just return.
  } catch (error) {
    return
  }

  // If we reach this point, continue resolving the route.
  next()
});

// When each route is finished evaluating...
router.afterEach((routeTo, routeFrom) => {
  NProgress.done()
})

export default router;

