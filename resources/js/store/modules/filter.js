import axios from 'axios';

const state = {
   filter: {},
   filterData: null,
};
const mutations = {
   setFilter(state, filter) {
      state.filter = filter;
   },
   setFilterData(state, filterData) {
      state.filterData = filterData;
   },
};
const actions = {
   updateFilter({ commit }, filter) {
      commit('setFilter', filter);
   },
   updateFilterData({ commit }, filterData) {
      commit('setFilterData', filterData);
   }
};
const getters = {
   getFilter: state => state.filter,
   getFilterData: state => state.filterData,
};

export default {
   state,
   mutations,
   actions,
   getters,

};
