
import axios from 'axios';

const state = {
   componentStates: {
      component1: true,
      component2: false,
   }
};

const mutations = {
   toggleComponent(state, componentName) {
      state.componentStates[componentName] = !state.componentStates[componentName];
   }
};

const actions = {
   toggleComponent({ commit }, componentName) {
      commit('toggleComponent', componentName);
   }
};

const getters = {
   componentState: state => componentName => {
      return state.componentStates[componentName];
   }
};

export default {
   state,
   mutations,
   actions,
   getters,
};
