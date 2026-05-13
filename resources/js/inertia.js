//js is only to load Inertia. Should be added to resources/views/inertia/InertiaBladeMainRootView/app.blade.php as  @vite('resources/js/inertia.js')

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

// match your actual folder
const pages = import.meta.glob('./InertiaComponents/**/*.vue')   //my folder
//const pages = import.meta.glob('./Pages/**/*.vue')

createInertiaApp({
  //resolve: name => import(`./Pages/${name}.vue`),  //causes error when component is in subfolder, i.e Pages/InertiaComponents/Users.vue

    resolve: (name) => {
    const path = `./${name}.vue` 

    const page = pages[path]

    if (!page) {
      console.log('Available pages:', Object.keys(pages))
      throw new Error(`Page not found: ${path}`)
    }

    return page()
  },



  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },
})