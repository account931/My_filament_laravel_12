//used to load Vue components. Not for Inertia, for inertia is inertia.js

import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';  //vue
import { createPinia } from 'pinia';     //Pinia store instead of Vuex
import router from './router/index.js';
import routerBooking from './router/router_for_booking.js';
//import $ from 'jquery';  //jquery  //import where it is used, e.g login.vue
import ElementPlus from 'element-plus'; //Element Plus instead of Element UI
import { Delete, Edit, Check } from '@element-plus/icons-vue';  //icons
import 'element-plus/dist/index.css';   //Element Plus instead of Element UI
import VCalendar from 'v-calendar';   //v calendar
import 'v-calendar/style.css';  //v calendar
import ExampleComponent    from './components/ExampleComponent.vue'; //vue example
import OwnersListComponent from './components/OwnersListComponents/GetOwnersListComponent.vue';
import RouterMenu from './components/OwnersListComponentsWithRouter/VueRouterMenu.vue';
import VenuesLocatorComponent from './components/VenuesStoreLocatorComponent/VenuesLocatorComponent.vue';
import BigQueryVue from './components/BigQuery/BigQueryStatsComponent.vue';
import Booking from './components/Booking/BookingComponent.vue';
import QuestionsComp from './components/Questions/QuestionsComponent.vue';
//import 'bootstrap/dist/css/bootstrap.min.css';

//for scout algolia
import './algolia_scout/algolia-search';

window.Alpine = Alpine; //used in dashboard menu drop down
Alpine.start();  //used in dashboard menu drop down


//start vue

const pinia = createPinia(); // Pinia store


// ==================================
// Vue App 1 - Dashboard example
// ==================================

//to fix error '[Vue warn]: Failed to mount app: mount target selector "#myExample'" returned null.'
const el = document.querySelector('#myExample'); //div id

if (el) {
  const app1 = createApp({});
  app1.component('example-component', ExampleComponent);
  app1.mount(el);
}

/*
const app1 = createApp({});  
app1.component('example-component',  ExampleComponent);
app1.mount('#myExample');  //div id
*/

// =========================
// Vue App 2 - Venues locator
// =========================

const el2 = document.querySelector('#venues-store-locator');

if (el2) {
  const app2 = createApp({});
  app2.component('venues-locator-component', VenuesLocatorComponent);
  app2.mount(el2);
}

/*
const app2= createApp({});  
app2.component('venues-locator-component', VenuesLocatorComponent);  //Vue VenuesLocatorComponent
app2.mount('#venues-store-locator');  //div id
*/



// =========================
// Vue App 3, simple Vue to get data from /api/owners
// =========================
const el3 = document.querySelector('#simpleVue');

if (el3) {
  const app3 = createApp({});
  app3.component('owners-list-component', OwnersListComponent);
  app3.use(pinia);
  app3.mount(el3);
}
/*
const app3 = createApp({});  
app3.component('owners-list-component', OwnersListComponent);        //Vue gets data from /api/owners
app3.use(pinia);        //Pinia store instead of Vuex
app3.mount('#simpleVue');  //div id
*/


// =========================
// Vue App 4 with router and store
// =========================
const el4 = document.querySelector('#vueRouter');

if (el4) {
  const appWithRouter = createApp({});
  appWithRouter.component('vue-router-menu-with-links-component', RouterMenu);
  appWithRouter.use(ElementPlus);
  appWithRouter.use(pinia);
  appWithRouter.use(router);
  appWithRouter.mount(el4);
}

/*
const appWithRouter = createApp({});  
appWithRouter.component('vue-router-menu-with-links-component', RouterMenu);  //Vue component with router
appWithRouter.use(ElementPlus);  //Element Plus instead of Element UI
appWithRouter.use(pinia);        //Pinia store instead of Vuex
appWithRouter.use(router);
appWithRouter.mount('#vueRouter');  //div id
*/


// =========================
// Vue App 5, BigQuery display stats Vue component
// =========================
const el5 = document.querySelector('#vueBigQuery');

if (el5) {
  const appBigQuery = createApp({});
  appBigQuery.component('vue-big-query-component', BigQueryVue);
  appBigQuery.use(ElementPlus);
  appBigQuery.mount(el5);
}

/*
const appBigQuery = createApp({});  
appBigQuery.component('vue-big-query-component', BigQueryVue);  //Vue component
appBigQuery.use(ElementPlus);  //Element Plus instead of Element UI
//appBigQuery.use(pinia);        //Pinia store instead of Vuex
//appBigQuery.use(router);
appBigQuery.mount('#vueBigQuery');  //div id
*/


//
// =========================
// Vue App 6, Booking Vue component
// =========================
const el6 = document.querySelector('#bookingVueSection');

if (el6) {
  const appBooking = createApp({});
  appBooking.component('booking-vue-component', Booking);
  appBooking.use(ElementPlus);
  appBooking.use(VCalendar);
  appBooking.use(routerBooking);
  appBooking.mount(el6);
}

/*
const appBooking = createApp({});  
appBooking.component('booking-vue-component', Booking);  //Vue component
appBooking.use(ElementPlus);  //Element Plus instead of Element UI
appBooking.use(VCalendar);  //use V-calendar package
//appBooking.use(pinia);        //Pinia store instead of Vuex
appBooking.use(routerBooking);
appBooking.mount('#bookingVueSection');  //div id
*/

//
//
// =========================
// Vue App 7, Questions Vue component
// =========================
const el7 = document.querySelector('#questions');

if (el7) {
  const appQuestions = createApp({});
  appQuestions.component('questions-vue-component', QuestionsComp);
  appQuestions.use(ElementPlus);
  appQuestions.mount(el7);
}
/*
const appQuestions = createApp({});  
appQuestions.component('questions-vue-component', QuestionsComp);  //Vue component used in Blade = component you load here
appQuestions.use(ElementPlus);  //Element Plus instead of Element UI
//appQuestions.use(pinia);        //Pinia store instead of Vuex
//appQuestions.use(routerBooking);
appQuestions.mount('#questions');  //div id
*/