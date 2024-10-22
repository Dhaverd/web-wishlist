import './js/bootstrap';
import {createApp} from 'vue'
import App from './App.vue'
import { createVuetify } from 'vuetify'
import 'vuetify/styles'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'
import { createMemoryHistory, createRouter } from 'vue-router'

const vuetify = createVuetify({
    components,
    directives
})

import AuthButtons from './views/AuthButtons.vue'
import Login from './views/Auth/Login.vue'
import Registration from './views/Auth/Registration.vue'
import Welcome from './views/Welcome.vue'

const routes = [
    { path: '/', component: Welcome },
    { path: '/auth_options', component: AuthButtons },
    { path: '/login', component: Login },
    { path: '/registration', component: Registration },
]

const router = createRouter({
    history: createMemoryHistory(),
    routes,
})

createApp(App).use(vuetify).use(router).mount("#app")
