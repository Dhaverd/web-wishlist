<script>
import {useUserStore} from "../../store/user.js";
import {useWishStore} from "../../store/wish.js";
import {rules} from "../../js/rules.js";
export default {
    name: "CreateWish",
    data: () => ({
        userStore: useUserStore(),
        wishStore: useWishStore(),
        name: null,
        price: null,
        url: null
    }),
    computed: {
        rules() {
            return rules
        }
    },
    props: {
        dialogCreate: Function,
        updateFrontWishes: Function
    },
    methods: {
        validate(){
            return rules.notNull(this.name);
        },
        createWish(){
            let validation = this.validate();
            if (typeof validation !== "boolean"){
                alert(validation);
                return;
            }
            this.wishStore.create(this.userStore.user['id'], this.name, this.price, this.url, this.userStore.token).then(()=>{
                this.updateFrontWishes();
                this.dialogCreate();
            });
        }
    }
}
</script>

<template>
    <v-card class="card-bg">
        <v-card-title class="d-flex justify-space-between">
            <span>Создать новый элемент</span>
            <span>
                <v-icon @click="dialogCreate" class="cursor-pointer" color="white" icon="mdi-close-thick"></v-icon>
            </span>
        </v-card-title>
        <v-card-text class="d-flex align-center flex-column w-100">
            <v-text-field class="w-100" label="Наименование" v-model="name" :rules="[rules.notNull]"></v-text-field>
            <v-text-field class="w-100" label="Стоимость" v-model="price"></v-text-field>
            <v-text-field class="w-100" label="Ссылка" v-model="url"></v-text-field>
            <v-btn class="w-33" @click="createWish">Создать</v-btn>
        </v-card-text>
    </v-card>
</template>

<style scoped>

</style>
