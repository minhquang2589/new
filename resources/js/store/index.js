import { createStore } from 'vuex';
import cart from './modules/cart';
import user from './modules/user';
import notification from './modules/showNotification';
import isViewCartVisible from '../store/modules/closeCart';
import currencyFormatter from './modules/formatCurrency.js';
import formatCurrencyInput from './modules/formatCurrencyInput.js';
import componentStates from './modules/component.js';


const store = createStore({
   modules: {
      cart,
      user,
      isViewCartVisible,
      notification,
      currencyFormatter,
      componentStates,
      formatCurrencyInput
   },
});

export default store;
