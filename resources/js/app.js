import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';  //vue
import { createPinia } from 'pinia';     //Piania store instead of Vuex
import ElementPlus from 'element-plus'; //Element Plus instead of Element UI
import 'element-plus/dist/index.css';   //Element Plus instead of Element UI
import ExampleComponent    from './components/ExampleComponent.vue'; //vue example
import OwnersListComponent from './components/OwnersListComponents/GetOwnersListComponent.vue';

window.Alpine = Alpine; //used in dashboard menu drop down
Alpine.start();  //used in dashboard menu drop down


//Vue.component('owners-list-component', require('./components/OwnersListComponents/GetOwnersListComponent.vue').default); //register component (default is a must fix)

//start vue
const app = createApp({});
const pinia = createPinia(); // Piania store

app.component('example-component', ExampleComponent);
app.component('owners-list-component', OwnersListComponent);

app.use(ElementPlus);  //Element Plus instead of Element UI
app.use(pinia);        //Piania store instead of Vuex

app.mount('#app');



