import axios from 'axios';

const getters = {
   formatCurrencyInput: () => (value) => {
      let formattedValue = value.toString().replace(/[^\d]/g, "");
      formattedValue = new Intl.NumberFormat("vi-VN", {
         style: "currency",
         currency: "VND",
      }).format(formattedValue);
      return formattedValue;
   }
};

export default {
   getters,
};
