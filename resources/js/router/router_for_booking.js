//Used in Booking Vue only

//Correct Setup for Vue 3 + vue-router 4
// router/index.js
import { createRouter, createWebHistory, createWebHashHistory } from 'vue-router';
import BookingVue   from '../components/Booking/subcomponents/BookingCalendarSubComponent.vue';


const routes = [
  {
    path: '/',
    redirect: '/booking/1',
  },

  
  //Booking Vue
    {
    path: '/booking/:id',
    name: 'booking-vue',
    component: BookingVue,
    props: true,
  },

];

const router = createRouter({
  history: createWebHashHistory(), // working fix, was getting localhost:8000/contact  instead of  localhost:8000/vue-pages-with-router /contact
  //history: createWebHistory('/vue-pages-with-router'),  //Vue Router takes over all routes under and corrupt routes/web.php
  //history: createWebHistory()
  routes,
});

export default router;
