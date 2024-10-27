<script>
import {useUserStore} from "../../store/user.js";
import {useWishStore} from "../../store/wish.js";
import axios from "axios";
export default {
    name: "Wishlist",
    data: () => ({
        userStore: useUserStore(),
        wishStore: useWishStore()
    }),
    methods: {
        tryWishes(){
            let token = this.userStore.token;
            let user_id = this.userStore.user['id'];
            // get wish list
            this.wishStore.getUserWishes(user_id, token).then((result)=>{
                console.log(result);
                // push new wish
                this.wishStore.create(user_id, 'Google', 42000, 'http://google.com/', token).then((response)=>{
                    console.log(response);
                    // get wish list
                    this.wishStore.getUserWishes(user_id, token).then((resultOfResponse)=>{
                        console.log(resultOfResponse);
                    });
                });
            });
        }
    }
}
</script>

<template>
    <v-label class="link-no-decor" @click="this.tryWishes">Hello world!</v-label>
</template>

<style scoped>

</style>
