export default {
   mounted(el, binding) {
     const effect = binding.value || 'fade';
     el.style.opacity = '0';
     el.style.transition = 'opacity 0.5s ease-out';
 
     if (effect === 'slide-in') {
       el.style.transform = 'translateY(20px)';
       el.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
     } else if (effect === 'zoom-in') {
       el.style.transform = 'scale(0.8)';
       el.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
     }
 
     const observer = new IntersectionObserver((entries) => {
       entries.forEach(entry => {
         if (entry.isIntersecting) {
           el.style.opacity = '1';
           if (effect === 'slide-in') {
             el.style.transform = 'translateY(0)';
           } else if (effect === 'zoom-in') {
             el.style.transform = 'scale(1)';
           }
         } else {
           el.style.opacity = '0';
           if (effect === 'slide-in') {
             el.style.transform = 'translateY(20px)';
           } else if (effect === 'zoom-in') {
             el.style.transform = 'scale(0.8)';
           }
         }
       });
     });
 
     observer.observe(el);
   }
 };
 