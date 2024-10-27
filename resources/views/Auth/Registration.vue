<script>
import {useUserStore} from "../../store/user.js";
import {rules} from "../../js/rules.js";

export default {
    name: "Registration",
    data: () => ({
        userStore: useUserStore(),
        valid: false,
        login: null,
        email: null,
        password: null,
        repeatPassword: null,
        errorMessage: '',
        errorMessageContainerStyle: 'display: none;',
        showPassword: false,
        showRepeatPassword: false
    }),
    computed: {
        rules() {
            return rules
        }
    },
    methods: {
        validate(){
            let emailValidation = rules.email(this.email);
            let loginValidation = rules.notNull(this.login);
            let passwordValidation = rules.notNull(this.password);
            let repeatPasswordValidation = rules.notNull(this.repeatPassword);
            let validation = [emailValidation, loginValidation, passwordValidation, repeatPasswordValidation];
            let check = null;
            validation.forEach((element)=>{
                if (typeof element !== "boolean"){
                    check = element;
                }
            })
            return check === null ? true : check;
        },
        registrationAction(){
            let validation = this.validate();
            if (validation !== true){
                alert(validation);
                return;
            }
            this.userStore.registration(this.login, this.email, this.password, this.repeatPassword).then((isRegistred)=>{
                if (typeof isRegistred == "boolean") {
                    if (isRegistred){
                        this.errorMessage = '';
                        this.errorMessageContainerStyle = 'display: none;';
                        this.$router.push('/');
                    } else {
                        this.errorMessage = 'Registration error';
                        this.errorMessageContainerStyle = '';
                    }
                } else if (typeof isRegistred == "string") {
                    this.errorMessage = isRegistred;
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
                      v-model="login"
                      label="Логин"
                      v-on:keyup.enter="this.registrationAction"
                      :rules="[rules.notNull]"
                      required
        ></v-text-field>
        <v-text-field class="w-100"
                      v-model="email"
                      label="E-mail"
                      type="email"
                      v-on:keyup.enter="this.registrationAction"
                      :rules="[rules.email]"
                      required
        ></v-text-field>
        <v-text-field class="w-100"
                      v-model="password"
                      label="Пароль"
                      :type="showPassword ? 'text' : 'password'"
                      :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                      @click:append="showPassword = !showPassword"
                      v-on:keyup.enter="this.registrationAction"
                      :rules="[rules.notNull]"
                      required
        ></v-text-field>
        <v-text-field class="w-100"
                      v-model="repeatPassword"
                      label="Повторите пароль"
                      :type="showRepeatPassword ? 'text' : 'password'"
                      :append-icon="showRepeatPassword ? 'mdi-eye' : 'mdi-eye-off'"
                      @click:append="showRepeatPassword = !showRepeatPassword"
                      v-on:keyup.enter="this.registrationAction"
                      :rules="[rules.notNull]"
                      required
        ></v-text-field>
        <v-label :style="errorMessageContainerStyle">{{ errorMessage }}</v-label>
        <v-btn @click="this.registrationAction">Регистрация</v-btn>
    </div>
<!--    <v-form v-model="valid"  @submit.prevent>-->
<!--        -->
<!--    </v-form>-->
</template>

<style scoped>

</style>
