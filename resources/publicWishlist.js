import './js/bootstrap';
import {createApp} from 'vue'
import PublicApp from './PublicApp.vue';
import { createVuetify } from 'vuetify'
import 'vuetify/styles'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'
import { createMemoryHistory, createRouter } from 'vue-router'
import {createPinia} from "pinia";

const vuetify = createVuetify({
    components,
    directives
})

const pinia = createPinia()

createApp(PublicApp).use(vuetify).use(pinia).mount("#app")
