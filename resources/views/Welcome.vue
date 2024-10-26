<template>
    <v-card class="bg-gradient" style="height: 100%">
        <v-card-text class="d-flex justify-center align-center">
            <v-card class="align-center justify-center h-auto w-66 card-bg">
                <v-card-title class="d-flex justify-space-between">
                    <div>
                        <span>Добро пожаловать в </span>
                        <span><router-link :to="isAuthenticated ? '/wishlist' : '/auth_options'" class="link-no-decor">Wishlist</router-link>, </span>
                        <span v-if="isAuthenticated">{{ this.user['name'] }}!</span>
                        <span v-else>Гость!</span>
                    </div>
                    <span v-if="isAuthenticated" class="link-no-decor align-end" @click="logout">Выйти</span>
                </v-card-title>
                <v-card-text class="d-flex justify-center align-center">
                    <router-view/>
                </v-card-text>
            </v-card>
        </v-card-text>
    </v-card>
</template>

<script>
import {useUserStore} from "../store/user.js";
import {watch} from "vue";
export default {
    name: "Welcome",
    data: () => ({
        isAuthenticated: false,
        userStore: useUserStore()
    }),
    computed: {
        user() {
            return this.userStore.user;
        },
    },
    methods: {
        async logout() {
            this.userStore.logout();
            this.$router.push('/auth_options');
        }
    },
    mounted() {
        this.$router.push('/auth_options');
        watch(this.userStore, (newStore, oldStore)=>{
            this.isAuthenticated = newStore.user !== null && newStore.user !== undefined;
            if (this.isAuthenticated) {
                this.$router.push('/wishlist');
            } else {
                this.$router.push('/auth_options');
            }
        });
        this.userStore.checkUser();
    }
}
</script>


<style scoped>

.bg-gradient {
    background: linear-gradient(-45deg, #000610, #000f25, #00152f);
    background-size: 100% 100%;
    height: 100vh;
}

.card-bg {
    background-color: #212022;
    color: white;
}

.link-no-decor {
    color: white;
    text-decoration: none;
}

.link-no-decor:hover {
    color: #093160;
}

</style>
