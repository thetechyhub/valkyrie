import Vue from 'vue';
import Vuex from 'vuex';

import Session from './modules/Session.js';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
  modules: {
		session: Session, 
  },
  strict: debug,
})