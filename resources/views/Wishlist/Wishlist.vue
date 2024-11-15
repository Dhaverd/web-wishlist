<script>
import {useUserStore} from "../../store/user.js";
import {useWishStore} from "../../store/wish.js";
import CreateWish from "./CreateWish.vue";
import {ref} from "vue";
import EditWish from "./EditWish.vue";
export default {
    name: "Wishlist",
    components: {EditWish, CreateWish},
    data: () => ({
        userStore: useUserStore(),
        wishStore: useWishStore(),
        isWide: window.innerWidth >= 800,
        wishesList: [],
        fetching: true,
        dialogCreate: ref(false),
        dialogEdit: ref(false),
        dialogDelete: ref(false),
        wishToDelete: ref(0),
        wishToEditId: ref(0),
        wishlistLink: '',
        snackbar: false
    }),
    mounted() {
        this.wishStore.getUserWishes(this.userStore.user['id']).then((wishes)=>{
            this.wishesList = wishes;
            this.wishlistLink = window.location.origin + '/wishlist/' + this.userStore.user['id'];
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
                this.dialogDelete = false;
                this.wishStore.getUserWishes(this.userStore.user['id']).then((wishes)=>{
                    this.wishesList = wishes;
                    this.fetching = false;
                });
            })
        },
        editWish(id){
            this.wishToEditId = id;
            this.dialogEdit = true;
        },
        deleteWish(id){
            this.wishToDelete = id;
            this.dialogDelete = true;
        },
        getWishToEditId(){
            return this.wishToEditId;
        },
        copyLink(){
            navigator.clipboard.writeText(this.wishlistLink);
            this.snackbar = true;
        }
    }
}
</script>

<template>
    <div class="d-flex flex-column">
        <v-skeleton-loader color="grey-darken-4" type="table" v-if="fetching"></v-skeleton-loader>
        <div v-if="!fetching" class="d-flex justify-center align-center w-100 pt-5">
            <v-text-field
                class="w-33"
                append-inner-icon="mdi-content-copy"
                @click:append-inner="copyLink"
                readonly
            >
            {{ wishlistLink }}
            </v-text-field>
            <v-snackbar v-model="snackbar">Текст скопирован!</v-snackbar>
        </div>
        <v-table v-if="!fetching && isWide" class="card-bg w-100 h-auto mt-5 pa-3">
            <thead>
                <tr>
                    <th class="text-subtitle-1">Наименование</th>
                    <th class="text-subtitle-1">Цена</th>
                    <th class="text-subtitle-1">Ссылка</th>
                    <th class="text-subtitle-1"></th>
                    <th class="text-subtitle-1"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="wish in wishesList">
                    <td>{{ wish['name'] }}</td>
                    <td>{{ wish['price'] }}</td>
                    <td><a target="_blank" :href="wish['url']">{{ wish['url'] }}</a></td>
                    <td><v-icon @click="editWish(wish['id'])" class="cursor-pointer" color="white" icon="mdi-pencil"></v-icon></td>
                    <td><v-icon @click="deleteWish(wish['id'])" class="cursor-pointer" color="white" icon="mdi-trash-can"></v-icon></td>
                </tr>
                <tr class="text-center">
                    <td colspan="5"><v-btn @click="dialogCreate = true" color="#212022" elevation="0" block><v-icon class="cursor-pointer" icon="mdi-plus-thick"></v-icon></v-btn></td>
                </tr>
            </tbody>
            <v-dialog v-model="dialogCreate" class="w-66">
                <CreateWish :dialogCreate="dialogCreateClose" :updateFrontWishes="updateFrontWishes"/>
            </v-dialog>
            <v-dialog v-model="dialogEdit" class="w-66">
                <EditWish :dialogEdit="dialogEditClose" :updateFrontWishes="updateFrontWishes" :wish_id="wishToEditId"/>
            </v-dialog>
            <v-dialog v-model="dialogDelete" :class="isWide ? 'w-33' : 'w-100'">
                <v-card class="card-bg">
                    <v-card-title class="d-flex justify-space-between">
                        <span>Удалить запись?</span>
                        <span>
                            <v-icon @click="dialogDelete = false" class="cursor-pointer" color="white" icon="mdi-close-thick"></v-icon>
                        </span>
                    </v-card-title>
                    <v-card-text>
                        <div class="d-flex justify-center">
                            <v-btn class="ma-3" @click="removeWish(wishToDelete)">Да</v-btn>
                            <v-btn class="ma-3" @click="dialogDelete = false">Нет</v-btn>
                        </div>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-table>
        <v-table v-if="!fetching && !isWide" class="card-bg w-100 h-auto mt-5 pa-3">
            <thead>
                <tr>
                    <th class="text-subtitle-1">Наименование</th>
                    <th class="text-subtitle-1">Цена</th>
                    <th class="text-subtitle-1"></th>
                    <th class="text-subtitle-1"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="wish in wishesList">
                    <td><a target="_blank" :href="wish['url']">{{ wish['name'] }}</a></td>
                    <td>{{ wish['price'] }}</td>
                    <td><v-icon @click="editWish(wish['id'])" class="cursor-pointer" color="white" icon="mdi-pencil"></v-icon></td>
                    <td><v-icon @click="deleteWish(wish['id'])" class="cursor-pointer" color="white" icon="mdi-trash-can"></v-icon></td>
                </tr>
                <tr class="text-center">
                    <td colspan="5"><v-btn @click="dialogCreate = true" color="#212022" elevation="0" block><v-icon class="cursor-pointer" icon="mdi-plus-thick"></v-icon></v-btn></td>
                </tr>
            </tbody>
            <v-dialog v-model="dialogCreate" :class="isWide ? 'w-66' : 'w-100'">
                <CreateWish :dialogCreate="dialogCreateClose" :updateFrontWishes="updateFrontWishes"/>
            </v-dialog>
            <v-dialog v-model="dialogEdit" :class="isWide ? 'w-66' : 'w-100'">
                <EditWish :dialogEdit="dialogEditClose" :updateFrontWishes="updateFrontWishes" :wish_id="wishToEditId"/>
            </v-dialog>
            <v-dialog v-model="dialogDelete" :class="isWide ? 'w-66' : 'w-100'">
                <v-card class="card-bg">
                    <v-card-title class="d-flex justify-space-between">
                        <span>Удалить запись?</span>
                        <span>
                            <v-icon @click="dialogDelete = false" class="cursor-pointer" color="white" icon="mdi-close-thick"></v-icon>
                        </span>
                    </v-card-title>
                    <v-card-text>
                        <div class="d-flex justify-center">
                            <v-btn class="ma-3" @click="removeWish(wishToDelete)">Да</v-btn>
                            <v-btn class="ma-3" @click="dialogDelete = false">Нет</v-btn>
                        </div>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-table>
    </div>
</template>

<style scoped>

</style>
