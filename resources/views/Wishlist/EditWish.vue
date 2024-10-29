<script>
import {useUserStore} from "../../store/user.js";
import {useWishStore} from "../../store/wish.js";
import {rules} from "../../js/rules.js";
import {watch} from "vue";
import {toRef, ref} from "vue";

export default {
    name: "EditWish",
    props: {
        dialogEdit: Function,
        updateFrontWishes: Function,
        wish_id: Number
    },
    data: () => ({
        userStore: useUserStore(),
        wishStore: useWishStore(),
        isWide: window.innerWidth >= 800,
        name: null,
        price: null,
        url: null,
        fetching: true,
        updating: false
    }),
    computed: {
        rules() {
            return rules
        }
    },
    setup(props) {
        const id = toRef(props, 'wish_id')
    },
    methods: {
        validate(){
            if (this.price == ""){
                this.price = null;
            }
            if (typeof this.price == 'string' && rules.isNumber(this.price)){
                this.price = parseFloat(this.price)
            }
            let validateId = rules.id(this.wish_id);
            let validateName = rules.notNull(this.name);
            let validatePrice = rules.price(this.price);
            let check = null;
            let valid = [validateId, validateName, validatePrice];
            valid.forEach((element)=>{
                if (typeof element !== "boolean"){
                    check = element;
                }
            });
            return check === null ? true : check;
        },
        editWish(){
            this.updating = true;
            let validation = this.validate();
            if (typeof validation !== "boolean"){
                console.log(this.price);
                this.updating = false;
                alert(validation);
                return;
            }
            this.wishStore.update(this.wish_id, this.userStore.user['id'], this.name, this.price, this.url, this.userStore.token).then(()=>{
                this.updating = false;
                this.updateFrontWishes();
                this.dialogEdit();
            });
        }
    },
    mounted() {
        this.wishStore.getWishById(this.wish_id, this.userStore.token).then((response)=>{
            this.name = response[0]['name'];
            this.price = response[0]['price'];
            this.url = response[0]['url'];
            this.fetching = false;
        })
    }
}
</script>

<template>
    <v-skeleton-loader color="grey-darken-4" type="card" v-if="fetching"></v-skeleton-loader>
    <v-card class="card-bg" v-else>
        <v-card-title class="d-flex justify-space-between">
            <span>Редактирование элемента</span>
            <span>
                <v-icon @click="dialogEdit" class="cursor-pointer" color="white" icon="mdi-close-thick"></v-icon>
            </span>
        </v-card-title>
        <v-card-text class="d-flex align-center flex-column w-100">
            <v-text-field class="w-100" label="Наименование" v-model="name" :rules="[rules.notNull]"></v-text-field>
            <v-text-field class="w-100" label="Стоимость" v-model="price"></v-text-field>
            <v-text-field class="w-100" label="Ссылка" v-model="url"></v-text-field>
            <v-btn :loading="updating" class="w-67" @click="editWish">Сохранить</v-btn>
        </v-card-text>
    </v-card>
</template>

<style scoped>

</style>
