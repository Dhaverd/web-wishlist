<script>
import { useWishStore } from "../../store/wish.js";
import { useUserStore } from "../../store/user.js";
export default {
    name: "ShowWhishlist",
    data: () => ({
        wishes: [],
        wishStore: useWishStore(),
        userStore: useUserStore(),
        fetching: false,
        username: ''
    }),
    mounted() {
        let urlArray = window.location.href.split('/');
        let user_id = urlArray[urlArray.length - 1];
        this.fetching = true;
        this.userStore.getUsername(user_id).then((res)=>{
            console.log(res);
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
    <v-table v-else class="card-bg w-100 h-auto mt-5 pa-3">
        <thead>
            <tr>
                <th colspan="3" class="text-center text-h5">Список пользователя {{ this.username }}</th>
            </tr>
            <tr>
                <th class="text-subtitle-1">Наименование</th>
                <th class="text-subtitle-1">Цена</th>
                <th class="text-subtitle-1">Ссылка</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="wish in wishes">
                <td>{{ wish['name'] }}</td>
                <td>{{ wish['price'] }}</td>
                <td><a target="_blank" :href="wish['url']">{{ wish['url'] }}</a></td>
            </tr>
        </tbody>
    </v-table>
</template>

<style scoped>

</style>
