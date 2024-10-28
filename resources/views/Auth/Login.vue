<script>
import {useUserStore} from "../../store/user.js";
import {rules} from "../../js/rules.js";

export default {
    name: "Login",
    computed: {
        rules() {
            return rules
        }
    },
    data: () => ({
        userStore: useUserStore(),
        valid: false,
        email: null,
        password: null,
        rememberMe: false,
        errorMessage: '',
        errorMessageContainerStyle: '',
        showPassword: false,
        loading: false
    }),
    methods: {
        validate(){
            let emailValidation = rules.email(this.email);
            let passwordValidation = rules.notNull(this.password);
            if (typeof emailValidation == "boolean" && typeof passwordValidation == "boolean"){
                return emailValidation && passwordValidation;
            } else if (typeof emailValidation == "string") {
                return emailValidation;
            } else if (typeof passwordValidation == "string") {
                return passwordValidation;
            }
        },
        loginAction(){
            this.loading = true;
            let validation = this.validate();
            if (validation !== true){
                alert(validation);
                return;
            }
            this.userStore.login(this.email, this.password, this.rememberMe).then((isLogged) => {
                this.loading = false;
                if (typeof isLogged == "boolean") {
                    if (isLogged){
                        this.errorMessage = '';
                        this.errorMessageContainerStyle = 'display: none;';
                        this.$router.push('/');
                    } else {
                        this.errorMessage = 'Authentication error';
                        this.errorMessageContainerStyle = '';
                    }
                } else if (typeof isLogged == "string") {
                    this.errorMessage = isLogged;
                    this.errorMessageContainerStyle = '';
                }
            });


        }
    }
}
</script>

<template>
    <div class="d-flex flex-column justify-center align-center w-33">
        <v-text-field class="w-100"
                      v-model="email"
                      label="E-mail"
                      type="email"
                      v-on:keyup.enter="this.loginAction"
                      :rules="[rules.email]"
                      required
        ></v-text-field>
        <v-text-field class="w-100"
                      v-model="password"
                      label="Пароль"
                      :type="showPassword ? 'text' : 'password'"
                      :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                      @click:append="showPassword = !showPassword"
                      v-on:keyup.enter="this.loginAction"
                      :rules="[rules.notNull]"
                      required
        ></v-text-field>
        <div class="d-flex justify-start align-content-start w-100">
            <v-checkbox v-model="rememberMe" label="Запомнить меня"></v-checkbox>
        </div>
        <v-label :style="errorMessageContainerStyle">{{ errorMessage }}</v-label>
        <v-btn @click="this.loginAction" :loading="loading">Войти</v-btn>
    </div>
</template>

<style scoped>

</style>
