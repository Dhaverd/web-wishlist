<script>
import {useUserStore} from "../../store/user.js";
import {useWishStore} from "../../store/wish.js";
import CreateWish from "./CreateWish.vue";
import {ref} from "vue";
export default {
    name: "Wishlist",
    components: {CreateWish},
    data: () => ({
        userStore: useUserStore(),
        wishStore: useWishStore(),
        wishesList: [],
        fetching: true,
        dialogCreate: ref(false),
        dialogEdit: ref(false)
    }),
    mounted() {
        this.wishStore.getUserWishes(this.userStore.user['id']).then((wishes)=>{
            this.wishesList = wishes;
            this.fetching = false
        });
    },
    methods: {
        dialogCreateClose(){
            this.dialogCreate = false;
        },
        dialogEditClose(){
            this.dialogEdit = false;
        },
        updateFrontWishes(){
            this.fetching = true;
            this.wishStore.getUserWishes(this.userStore.user['id']).then((wishes)=>{
                this.wishesList = wishes;
                this.fetching = false
            });
        },
        removeWish(id){
            this.fetching = true;
            this.wishStore.remove(id, this.userStore.token).then(()=>{
                this.wishStore.getUserWishes(this.userStore.user['id']).then((wishes)=>{
                    this.wishesList = wishes;
                    this.fetching = false;
                });
            })
        },
        editWish(id){

        },
        createWish(){

        }
    }
}
</script>

<template>
<!--    <v-label class="link-no-decor" @click="this.tryWishes">Hello world!</v-label>-->
    <v-skeleton-loader color="grey-darken-4" type="table" v-if="fetching"></v-skeleton-loader>
    <v-table v-else class="card-bg w-100 h-auto mt-5 pa-3">
        <thead>
            <tr>
                <th>Наименование</th>
                <th>Цена</th>
                <th>Ссылка</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="wish in wishesList">
                <td>{{ wish['name'] }}</td>
                <td>{{ wish['price'] }}</td>
                <td><a target="_blank" :href="wish['url']">{{ wish['url'] }}</a></td>
                <td><v-icon @click="" class="cursor-pointer" color="white" icon="mdi-pencil"></v-icon></td>
                <td><v-icon @click="removeWish(wish['id'])" class="cursor-pointer" color="white" icon="mdi-trash-can"></v-icon></td>
            </tr>
            <tr class="text-center">
                <td colspan="5"><v-btn @click="dialogCreate = true" color="#212022" elevation="0" block><v-icon class="cursor-pointer" icon="mdi-plus-thick"></v-icon></v-btn></td>
            </tr>
        </tbody>
        <v-dialog v-model="dialogCreate" class="w-66">
            <CreateWish :dialogCreate="dialogCreateClose" :updateFrontWishes="updateFrontWishes"/>
        </v-dialog>
    </v-table>
</template>

<style scoped>

</style>
