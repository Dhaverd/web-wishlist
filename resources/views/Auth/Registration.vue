<script>
import axios from "axios";

export default {
    name: "Registration",
    data: () => ({
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
            axios.post(
                '/api/auth/register',
                {'name': this.login,
                    'email': this.email,
                    'password': this.password,
                    'c_password': this.repeatPassword
            }).then((res) => {
                console.log(res);
                this.$router.push('/');
            }).catch((error)=>{
                this.errorMessage = error;
                this.errorMessageContainerStyle = '';
            })
        }
    }
}
</script>

<template>
    <div class="d-flex flex-column justify-center align-center">
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
