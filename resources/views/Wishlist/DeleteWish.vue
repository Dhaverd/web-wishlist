<script>
import {useUserStore} from "../../store/user.js";
import {useWishStore} from "../../store/wish.js";
import {rules} from "../../js/rules.js";
import {toRef} from "vue";
export default {
    name: "DeleteWish",
    data: () => ({
        userStore: useUserStore(),
        wishStore: useWishStore(),
        isWide: window.innerWidth >= 800,
        deleting: false
    }),
    computed: {
        rules() {
            return rules
        }
    },
    props: {
        dialogDelete: Function,
        updateFrontWishes: Function,
        wish_id: Number
    },
    setup(props) {
        const id = toRef(props, 'wish_id')
    },
    methods: {
        removeWish(){
            this.deleting = true;
            this.wishStore.remove(this.wish_id, this.userStore.token).then(()=>{
                this.deleting = false;
                this.updateFrontWishes();
                this.dialogDelete();
            });
        }
    }
}
</script>

<template>
    <v-card class="card-bg">
        <v-card-title class="d-flex justify-space-between">
            <span>Удалить запись?</span>
            <span>
                            <v-icon @click="dialogDelete" class="cursor-pointer" color="white" icon="mdi-close-thick"></v-icon>
                        </span>
        </v-card-title>
        <v-card-text>
            <div class="d-flex justify-center">
                <v-btn class="ma-3" @click="removeWish" :loading="deleting">Да</v-btn>
                <v-btn class="ma-3" @click="dialogDelete">Нет</v-btn>
            </div>
        </v-card-text>
    </v-card>
</template>

<style scoped>

</style>
