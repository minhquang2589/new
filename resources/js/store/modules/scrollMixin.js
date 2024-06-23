
export default {
   methods: {
       scrollToProductList() {
           this.$nextTick(() => {
               const productList = this.$refs.productList;
               if (productList) {
                   this.smoothScrollTo(productList.offsetTop);
               }
           });
       },
       smoothScrollTo(targetPosition, duration = 800) {
           const start = window.pageYOffset;
           const startTime = performance.now();
           const easeOutQuad = (t) => t * (2 - t);
           const scroll = (currentTime) => {
               const timeElapsed = currentTime - startTime;
               const progress = Math.min(timeElapsed / duration, 1);
               const ease = easeOutQuad(progress);
               window.scrollTo(0, start + (targetPosition - start) * ease);
               if (progress < 1) {
                   requestAnimationFrame(scroll);
               }
           };

           requestAnimationFrame(scroll);
       },
   },
};
