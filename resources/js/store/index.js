import { createStore } from 'vuex';
import cart from './modules/cart';
import user from './modules/user';
import notification from './modules/showNotification';
import currencyFormatter from './modules/formatCurrency.js';
import formatCurrencyInput from './modules/formatCurrencyInput.js';
import filter from './modules/filter';


const store = createStore({
   modules: {
      cart,
      user,
      notification,
      currencyFormatter,
      formatCurrencyInput,
      filter,
   },
});

export default store;
