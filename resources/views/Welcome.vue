<template>
    <v-card class="bg-gradient" style="height: 100%">
        <v-card-text class="d-flex justify-center align-center">
            <v-card class="align-center justify-center h-auto w-33 card-bg">
                <v-card-title>Добро пожаловать в <router-link to="/auth_options" class="link-no-decor">Wishlist</router-link>!</v-card-title>
                <v-card-text>
                    <router-view/>
                </v-card-text>
            </v-card>
        </v-card-text>
    </v-card>
</template>

<script>
import axios from "axios";
export default {
    name: "Welcome",
    data: () => ({
        cardTitle: 'Hello world!',
        username: ''
    }),
    mounted() {
        this.$router.push('/auth_options');
        axios.get(
            '/api/auth/user'
        ).then((res) => {
            console.log(res);
        })
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
