//Correct Setup for Vue 3 + vue-router 4
// router/index.js
import { createRouter, createWebHistory, createWebHashHistory } from 'vue-router';

import my_info_page from '../components/OwnersListComponentsWithRouter/pages/my-page.vue';
import services     from '../components/OwnersListComponentsWithRouter/pages/services.vue';
import contact      from '../components/OwnersListComponentsWithRouter/pages/contact.vue';
import owners_list  from '../components/OwnersListComponentsWithRouter/pages/owners-list.vue';
import detailsInfo  from '../components/OwnersListComponentsWithRouter/pages/details-info.vue';
import quantity_pr  from '../components/OwnersListComponentsWithRouter/pages/quantity-protected.vue';
import register     from '../components/OwnersListComponentsWithRouter/pages/LoginRegister/subcomponents/register.vue';
import loginPage    from '../components/OwnersListComponentsWithRouter/pages/LoginRegister/auth-start-page.vue';
import BookingVue   from '../components/Booking/subcomponents/BookingCalendarSubComponent.vue';


const routes = [
  {
    path: '/',
    name: 'my-info-page',
    component: my_info_page,
  },

  //L12 fix, as no default page was working
  /*
  {
    path: '/vue-pages-with-router',
    name: 'my-info-page',
    component: my_info_page,
  },
  */


  {
    path: '/my-page',
    name: 'my-info-page-alias',
    component: my_info_page,
  },
  {
    path: '/register-api',
    name: 'register-path',
    component: register,
  },
  {
    path: '/services',
    name: 'services',
    component: services,
  },
  {
    path: '/contact',
    name: 'contact',
    component: contact,
  },
  {
    path: '/owners-list',
    name: 'owners-list',
    component: owners_list,
  },
  {
    path: '/details-info/:Pidd',
    name: 'details-info',
    component: detailsInfo,
  },
  {
    path: '/login-reg',
    name: 'login-reg',
    component: loginPage,
  },
  {
    path: '/quantity-protected',
    name: 'quantity-protected',
    component: quantity_pr,
  },

  //went to separate router => router_for_booking.js
  /*
  //Booking Vue
    {
    path: '/booking/:id',
    name: 'booking-vue',
    component: BookingVue,
    props: true,
  },
  */

];

const router = createRouter({
  history: createWebHashHistory(), // working fix, was getting localhost:8000/contact  instead of  localhost:8000/vue-pages-with-router /contact
  //history: createWebHistory('/vue-pages-with-router'),  //Vue Router takes over all routes under and corrupt routes/web.php
  //history: createWebHistory()
  routes,
});

export default router;
