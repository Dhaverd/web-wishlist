import './js/bootstrap';
import {createApp} from 'vue'
import App from './App.vue'
import { createVuetify } from 'vuetify'
import 'vuetify/styles'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'
import {createPinia} from "pinia";

const vuetify = createVuetify({
    components,
    directives
})

import router from './js/router.js'

const pinia = createPinia()

createApp(App).use(vuetify).use(router).use(pinia).mount("#app")
