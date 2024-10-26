<script>
import axios from "axios";
import {useUserStore} from "../../store/user.js";

export default {
    name: "Login",
    data: () => ({
        userStore: useUserStore(),
        valid: false,
        email: '',
        password: '',
        rememberMe: false,
        errorMessage: '',
        errorMessageContainerStyle: ''
    }),
    methods: {
        loginAction(){
            axios.post(
                '/api/auth/login',
                {'name': this.login,
                    'email': this.email,
                    'password': this.password,
                    'remember_me': this.rememberMe
                }).then((res) => {
                this.userStore.setUser(res.data.user);
                this.userStore.setToken(res.data.accessToken);
                this.$router.push('/');
            }).catch((error)=>{
                if (!error.response){
                    this.errorMessage = '';
                    this.errorMessageContainerStyle = 'display: none;';
                    return;
                }
                this.errorMessage = error.response.data.message;
                this.errorMessageContainerStyle = '';
            })
        }
    }
}
</script>

<template>
    <div class="d-flex flex-column justify-center align-center w-33">
        <v-text-field class="w-100"
                      v-model="email"
                      label="E-mail"
                      required
        ></v-text-field>
        <v-text-field class="w-100"
                      v-model="password"
                      label="Пароль"
                      type="password"
                      required
        ></v-text-field>
        <div class="d-flex justify-start align-content-start w-100">
            <v-checkbox v-model="rememberMe" label="Запомнить меня"></v-checkbox>
        </div>
        <v-label :style="errorMessageContainerStyle">{{ errorMessage }}</v-label>
        <v-btn @click="this.loginAction">Войти</v-btn>
    </div>
</template>

<style scoped>

</style>
