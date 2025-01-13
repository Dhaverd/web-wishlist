<script>
import { useWishStore } from "../../store/wish.js";
import { useUserStore } from "../../store/user.js";
import DeleteWish from "../Wishlist/DeleteWish.vue";
import CreateWish from "../Wishlist/CreateWish.vue";
import EditWish from "../Wishlist/EditWish.vue";
import {watch} from "vue";
export default {
    name: "ShowWhishlist",
    components: {EditWish, CreateWish, DeleteWish},
    data: () => ({
        isAuthenticated: false,
        isSameUser: false,
        wishes: [],
        wishStore: useWishStore(),
        userStore: useUserStore(),
        isWide: window.innerWidth >= 1061,
        fetching: false,
        username: '',
        bookConfirmationDialog: false,
        bookItemId: '',
        bookItemName: '',
        bookError: false,
        bookErrorText: '',
        bookLoading: false
    }),
    methods: {
        bookDialog(id, name){
            this.bookItemId = id;
            this.bookItemName = name;
            this.bookConfirmationDialog = true;
        },
        closeBookDialog(){
            this.bookConfirmationDialog = false;
        },
        updateFrontWishes(){
            this.fetching = true;
            let urlArray = window.location.href.split('/');
            let user_id = urlArray[urlArray.length - 1];
            this.wishStore.getUserWishes(user_id).then((res)=>{
                this.wishes = res;
                this.fetching = false;
            });
        },
        book(){
            this.bookLoading = true;
            this.wishStore.book(this.bookItemId, this.userStore.user["id"], this.userStore.token).then((response)=>{
                this.bookError = false;
                if (response.request.status == 409){
                    this.bookErrorText = response.response.data.error;
                    this.bookError = true;
                } else {
                    this.bookConfirmationDialog = false;
                    this.updateFrontWishes();
                }
                this.bookLoading = false;
            }).catch(()=>{
                this.bookLoading = false;
            });
        },
        unbook(id){
            this.wishStore.unbook(id, this.userStore.token).then(()=>{
                this.updateFrontWishes();
            });
        }
    },
    mounted() {
        let urlArray = window.location.href.split('/');
        let user_id = urlArray[urlArray.length - 1];
        watch(this.userStore, (newStore, oldStore)=>{
            this.isAuthenticated = newStore.user !== null && newStore.user !== undefined;
            if (newStore.user !== null && newStore.user !== undefined){
                this.isSameUser = user_id == this.userStore.user['id'];
            }
        });
        this.fetching = true;
        this.userStore.getUsername(user_id).then((res)=>{
            this.username = res.data.username;
            this.wishStore.getUserWishes(user_id).then((responce)=>{
                this.wishes = responce;
                this.fetching = false;
            });
        });
    }
}
</script>

<template>
    <v-skeleton-loader color="grey-darken-4" type="table" v-if="fetching"></v-skeleton-loader>
    <v-table v-if="!fetching && isWide" class="card-bg w-100 h-auto mt-5 pa-3">
        <thead>
            <tr>
                <th colspan="4" class="text-center text-h5">Список пользователя {{ this.username }}</th>
            </tr>
            <tr>
                <th class="text-subtitle-1">Наименование</th>
                <th class="text-subtitle-1">Цена</th>
                <th class="text-subtitle-1">Ссылка</th>
                <th class="text-subtitle-1">Забронировано</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="wish in wishes">
                <td>{{ wish['name'] }}</td>
                <td>{{ wish['price'] }}</td>
                <td><a target="_blank" :href="wish['url']">{{ wish['url'] }}</a></td>
                <td>
                    <span v-if="wish['book_user'] === null">
                        <v-btn v-if="isAuthenticated && !isSameUser" @click="bookDialog(wish['id'], wish['name'])">Забронировать</v-btn>
                        <span v-else>Нет</span>
                    </span>
                    <span v-else>Да <v-icon @click="unbook(wish['id'])" v-if="isAuthenticated && userStore.user['id'] == wish['book_user']['id']" class="cursor-pointer" icon="mdi-close-thick" color="red"></v-icon></span>
<!--                    <span v-else><v-icon color="green" icon="mdi-check-bold"></v-icon></span>-->
                </td>
            </tr>
        </tbody>
        <v-dialog v-model="bookConfirmationDialog" class="w-33">
            <v-card class="card-bg">
                <v-card-text>
                    <div>
                        <v-label style="text-wrap: auto;">Хотите забронировать {{ bookItemName }}?</v-label>
                        <div class="d-flex justify-center">
                            <v-btn @click="book" :loading="bookLoading" class="mt-2 ml-2 mr-2">Да</v-btn>
                            <v-btn @click="closeBookDialog" class="mt-2 ml-2 mr-2">Нет</v-btn>
                        </div>
                    </div>
                    <div>

                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-table>
    <!-- Для мобилок -->
    <div v-if="!fetching && !isWide" class="w-100">
        <div v-for="wish in wishes">
            <div class="d-flex align-center">
                <v-label class="mr-3 text-h6" style="text-wrap: auto;"><a target="_blank" :href="wish['url']">{{ wish['name'] }}</a></v-label>
            </div>
            <div class="d-flex flex-column">
                <v-label class="mr-3 ml-5 text-body-1">Цена: {{ wish['price'] }}₽</v-label>
                <v-label class="mr-3 ml-5 text-body-1">Забронировано:&nbsp;
                    <span v-if="wish['book_user'] === null">
                        <v-btn v-if="isAuthenticated && !isSameUser" @click="bookDialog(wish['id'], wish['name'])" :size="isWide ? '' : 'small'">Забронировать</v-btn>
                        <span v-else>Нет</span>
                    </span>
                    <span v-else> Да <v-icon @click="unbook(wish['id'])" v-if="isAuthenticated && userStore.user['id'] == wish['book_user']['id']" class="cursor-pointer" icon="mdi-close-thick" color="red"></v-icon></span>
                </v-label>
            </div>
        </div>
        <v-dialog v-model="bookConfirmationDialog">
            <v-card class="card-bg">
                <v-card-text>
                    <v-label style="text-wrap: auto;">Хотите забронировать {{ bookItemName }}?</v-label>
                    <div class="d-flex justify-center">
                        <v-btn @click="book" :loading="bookLoading" class="mt-2 ml-2 mr-2">Да</v-btn>
                        <v-btn @click="closeBookDialog" class="mt-2 ml-2 mr-2">Нет</v-btn>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<style scoped>
.smth {
    color: darkorange;
}
</style>
