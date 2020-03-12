import Vue from 'vue';
import Vuex from 'vuex';
import Utility from '@/utils/Utility';

import modules from './modules';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

const store = new Vuex.Store({
  modules,
  strict: debug,
});

export default store;

Utility.dispatchModulesActions("init");