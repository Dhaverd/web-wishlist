import Welcome from "../views/Welcome.vue";
import AuthButtons from "../views/Auth/AuthButtons.vue";
import Login from "../views/Auth/Login.vue";
import Registration from "../views/Auth/Registration.vue";
import Wishlist from "../views/Wishlist/Wishlist.vue";
import {createMemoryHistory, createRouter} from "vue-router";

const routes = [
    { path: '/', component: Welcome },
    { path: '/auth_options', component: AuthButtons },
    { path: '/login', component: Login },
    { path: '/registration', component: Registration },
    { path: '/wishlist', component: Wishlist },
]

const router = createRouter({
    history: createMemoryHistory(),
    routes,
})

import auth from './middleware/auth.js';

router.beforeEach(auth);

export default router;
