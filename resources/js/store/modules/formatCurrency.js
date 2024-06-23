import axios from 'axios';

const state = {
   currencyFormatter: new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
   })
};
const getters = {
   formatCurrency: (state) => (value) => {
      return state.currencyFormatter.format(value);
   }
};

export default {
   state,
   getters,
};
