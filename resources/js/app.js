import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';  //vue
import { createPinia } from 'pinia';     //Piania store instead of Vuex
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

window.Alpine = Alpine; //used in dashboard menu drop down
Alpine.start();  //used in dashboard menu drop down


//start vue

const pinia = createPinia(); // Piania store


//Vue App 1, jsut example in dashboard
const app1 = createApp({});  
app1.component('example-component',  ExampleComponent);
app1.mount('#myExample');  //div id


//Vue App 2, Vue store locator
const app2= createApp({});  
app2.component('venues-locator-component', VenuesLocatorComponent);  //Vue VenuesLocatorComponent
app2.mount('#venues-store-locator');  //div id

//Vue App 3, simple Vue to get data from /api/owners
const app3 = createApp({});  
app3.component('owners-list-component', OwnersListComponent);        //Vue gets data from /api/owners
app3.use(pinia);        //Piania store instead of Vuex
app3.mount('#simpleVue');  //div id



//Vue App 4 with router and store
const appWithRouter = createApp({});  
appWithRouter.component('vue-router-menu-with-links-component', RouterMenu);  //Vue component with router
appWithRouter.use(ElementPlus);  //Element Plus instead of Element UI
appWithRouter.use(pinia);        //Piania store instead of Vuex
appWithRouter.use(router);
appWithRouter.mount('#vueRouter');  //div id

//Vue App 5, BigQuery display stats Vue component
const appBigQuery = createApp({});  
appBigQuery.component('vue-big-query-component', BigQueryVue);  //Vue component
appBigQuery.use(ElementPlus);  //Element Plus instead of Element UI
//appBigQuery.use(pinia);        //Piania store instead of Vuex
//appBigQuery.use(router);
appBigQuery.mount('#vueBigQuery');  //div id

//Vue App 5, Booking Vue component
const appBooking = createApp({});  
appBooking.component('booking-vue-component', Booking);  //Vue component
appBooking.use(ElementPlus);  //Element Plus instead of Element UI
appBooking.use(VCalendar);  //use V-calendar package
//appBooking.use(pinia);        //Piania store instead of Vuex
appBooking.use(routerBooking);
appBooking.mount('#bookingVueSection');  //div id


//Vue App 6, Questions Vue component
const appQuestions = createApp({});  
appQuestions.component('questions-vue-component', QuestionsComp);  //Vue component used in Blade = component you load here
appQuestions.use(ElementPlus);  //Element Plus instead of Element UI
//appQuestions.use(pinia);        //Piania store instead of Vuex
//appQuestions.use(routerBooking);
appQuestions.mount('#questions');  //div id