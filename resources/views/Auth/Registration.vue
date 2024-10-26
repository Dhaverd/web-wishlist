<script>
import {useUserStore} from "../../store/user.js";

export default {
    name: "Registration",
    data: () => ({
        userStore: useUserStore(),
        valid: false,
        login: '',
        email: '',
        password: '',
        repeatPassword: '',
        errorMessage: '',
        errorMessageContainerStyle: 'display: none;'
    }),
    methods: {
        registrationAction(){
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
                      required
        ></v-text-field>
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
        <v-text-field class="w-100"
                      v-model="repeatPassword"
                      label="Повторите пароль"
                      type="password"
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
