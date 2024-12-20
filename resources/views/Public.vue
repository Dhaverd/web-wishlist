<template>
    <v-card class="bg-gradient" style="height: 100%">
        <v-card-text class="d-flex justify-center align-center">
            <v-card class="align-center justify-center h-auto card-bg" :class="isWide ? 'w-66' : 'w-100'">
                <v-card-title class="d-flex justify-space-between">
                    <div>
                        <span>Добро пожаловать в </span>
                        <span><a href="/" class="link-no-decor">Wishlist</a>,&nbsp;</span>
                        <span v-if="userStore.user !== null">{{ userStore.user['name'] }}</span>
                        <span v-else>Гость</span>
                    </div>
                    <span v-if="isAuthenticated" class="link-no-decor align-end" @click="logout">Выйти</span>
                    <div v-else>
                        <a class="link-no-decor align-end" @click="showAuthDialog = true">Вход/Регистрация</a>
                    </div>
                    <v-dialog v-model="showAuthDialog">
                        <v-card class="card-bg">
                            <v-card-title class="d-flex justify-end">
                                <v-icon @click="showAuthDialog = false" class="cursor-pointer" color="white" icon="mdi-close-thick"></v-icon>
                            </v-card-title>
                        </v-card>
                    </v-dialog>
                </v-card-title>
                <v-card-text class="d-flex justify-center align-center h-auto">
                    <ShowWhishlist/>
                </v-card-text>
            </v-card>
        </v-card-text>
    </v-card>
</template>

<script>
import ShowWhishlist from "./PublicWishlist/ShowWhishlist.vue";
import {useUserStore} from "../store/user.js";
import { watch } from "vue";
export default {
    name: "Public",
    components: {ShowWhishlist},
    data: ()=>({
        isAuthenticated: false,
        isWide: window.innerWidth >= 800,
        userStore: useUserStore(),
        showAuthDialog: false
    }),
    mounted() {
        watch(this.userStore, (newStore, oldStore)=>{
            this.isAuthenticated = newStore.user !== null && newStore.user !== undefined;
        });
        useUserStore().checkUser();
    },
    methods: {
        async logout() {
            this.userStore.logout();
            window.location.reload();
        }
    }
}
</script>


<style scoped>

.bg-gradient {
    background: linear-gradient(-45deg, #000610, #000f25, #00152f);
    background-size: 100% 100%;
    height: 100vh;
}

</style>
