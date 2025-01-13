<template>
    <v-card class="bg-gradient" style="height: 100%" :class="isWide ? '' : 'd-flex justify-center align-center'">
        <v-card-text class="d-flex justify-center align-center">
            <v-card class="align-center justify-center h-auto card-bg" :class="isWide ? 'w-66' : 'w-100'">
                <v-card-title class="d-flex justify-space-between" :class="isWide ? '' : 'text-subtitle-1'">
                    <div v-if="isWide">
                        <span>Добро пожаловать в </span>
                        <span><a href="/" class="link-no-decor">Wishlist</a>,&nbsp;</span>
                        <span v-if="userStore.user !== null">{{ userStore.user['name'] }}</span>
                        <span v-else>Гость</span>
                    </div>
                    <div v-if="!isWide">
                        <p>Добро пожаловать в </p>
                        <p><a href="/" class="link-no-decor">Wishlist</a>, {{ isAuthenticated ? userStore.user['name'] : 'Гость' }}!</p>
                    </div>
                    <span v-if="isAuthenticated" class="link-no-decor align-end" @click="logout">Выйти</span>
                    <div v-else>
                        <div v-if="isWide"><a class="link-no-decor align-end" @click="showAuthDialog = true">Вход/Регистрация</a></div>
                        <div v-else class="d-flex flex-column justify-center align-end" @click="showAuthDialog = true">
                            <a class="link-no-decor">Вход/</a>
                            <a class="link-no-decor">Регистрация</a>
                        </div>
                    </div>
                    <v-dialog v-model="showAuthDialog" :class="isWide ? 'w-66' : 'w-100'">
                        <v-card class="card-bg">
                            <v-card-title class="d-flex justify-end">
                                <v-icon @click="showAuthDialog = false" class="cursor-pointer" color="white" icon="mdi-close-thick"></v-icon>
                            </v-card-title>
                            <v-card-text class="w-100">
                                <v-tabs class="w-100" align-tabs="center" v-model="tab">
                                    <v-tab :value="1">Вход</v-tab>
                                    <v-tab :value="2">Регистрация</v-tab>
                                </v-tabs>
                                <v-tabs-window v-model="tab" class="w-100 h-auto">
                                    <v-tabs-window-item :key="1" :value="1">
                                        <v-container fluid class="d-flex align-center justify-center"><Login/></v-container>
                                    </v-tabs-window-item>
                                    <v-tabs-window-item :key="2" :value="2">
                                        <v-container fluid class="d-flex align-center justify-center"><Registration/></v-container>
                                    </v-tabs-window-item>
                                </v-tabs-window>
                            </v-card-text>
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
import Login from "./Auth/Login.vue";
import Registration from "./Auth/Registration.vue";
export default {
    name: "Public",
    components: {Registration, Login, ShowWhishlist},
    data: ()=>({
        isAuthenticated: false,
        isWide: window.innerWidth >= 800,
        userStore: useUserStore(),
        showAuthDialog: false,
        tab: null
    }),
    mounted() {
        watch(this.userStore, (newStore, oldStore)=>{
            this.isAuthenticated = newStore.user !== null && newStore.user !== undefined;
            if (this.isAuthenticated){
                this.showAuthDialog = false;
            }
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
