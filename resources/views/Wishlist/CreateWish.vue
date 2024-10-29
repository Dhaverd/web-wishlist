<script>
import {useUserStore} from "../../store/user.js";
import {useWishStore} from "../../store/wish.js";
import {rules} from "../../js/rules.js";
export default {
    name: "CreateWish",
    data: () => ({
        userStore: useUserStore(),
        wishStore: useWishStore(),
        isWide: window.innerWidth >= 800,
        name: null,
        price: null,
        url: null,
        creating: false
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
            if (this.price == ''){
                this.price = null;
            }
            if (typeof this.price == 'string' && rules.isNumber(this.price)){
                this.price = parseFloat(this.price)
            }
            let validateName = rules.notNull(this.name);
            let validatePrice = rules.price(this.price);
            let check = null;
            let valid = [validateName, validatePrice];
            valid.forEach((element)=>{
                if (typeof element !== "boolean"){
                    check = element;
                }
            });
            return check === null ? true : check;
        },
        createWish(){
            this.creating = true;
            let validation = this.validate();
            if (typeof validation !== "boolean"){                
                this.creating = false;
                alert(validation);
                return;
            }
            this.wishStore.create(this.userStore.user['id'], this.name, this.price, this.url, this.userStore.token).then(()=>{
                this.creating = false;
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
            <span>Создание</span>
            <span>
                <v-icon @click="dialogCreate" class="cursor-pointer" color="white" icon="mdi-close-thick"></v-icon>
            </span>
        </v-card-title>
        <v-card-text class="d-flex align-center flex-column w-100">
            <v-text-field class="w-100" label="Наименование" v-model="name" :rules="[rules.notNull]"></v-text-field>
            <v-text-field class="w-100" label="Стоимость" v-model="price"></v-text-field>
            <v-text-field class="w-100" label="Ссылка" v-model="url"></v-text-field>
            <v-btn class="w-33" @click="createWish" :loading="creating">Создать</v-btn>
        </v-card-text>
    </v-card>
</template>

<style scoped>

</style>
