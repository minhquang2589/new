
import axios from 'axios';

const state = {
   user: {
      isAdmin: false,
      isAuthenticated: false,
   },
   userdata: null,
};

const mutations = {
   setUser(state, user) {
      state.user = {
         name: user.name,
         isAdmin: user.role === 'admin',
         isAuthenticated: true,
      };
   },
   setUserData(state, userdata) {
      state.userdata = userdata;
   },
};

const actions = {
   fetchUser({ commit }) {
      axios
         .get('/api/user')
         .then((response) => {
            // console.log(response.data);
            commit('setUser', response.data);
            commit('setUserData', response.data.user);
         })
         .catch(() => {
            commit('setUser', { isAdmin: false, isAuthenticated: false });
         });
   },
};

const getters = {
   isAdmin: (state) => state.user.isAdmin,
   userData: (state) => state.userdata,
   isAuthenticated: (state) => state.user.isAuthenticated,
};

export default {
   state,
   mutations,
   actions,
   getters,
};
