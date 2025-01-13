<script>
import {useUserStore} from "../../store/user.js";
import {watch} from "vue";
import {useFeedbackStore} from "../../store/feedback.js";

export default {
    name: "FeedbackFooter",
    data: () => ({
        isAuthenticated: false,
        userStore: useUserStore(),
        feedbackStore: useFeedbackStore(),
        isWide: window.innerWidth >= 800,
        showFeedbackDialog: false,
        loadingFeedback: false,
        feedbackText: ''
    }),
    methods: {
        sendFeedback(){
            this.loadingFeedback = true;
            let user_id = this.isAuthenticated ? this.userStore.user['id'] : null;
            this.feedbackStore.create(user_id, this.feedbackText).then(()=>{
                this.loadingFeedback = false;
                this.showFeedbackDialog = false;
                this.feedbackText = '';
            });
        }
    },
    mounted() {
        watch(this.userStore, (newStore, oldStore)=>{
            this.isAuthenticated = newStore.user !== null && newStore.user !== undefined;
        });
    }
}
</script>

<template>
    <div @click="showFeedbackDialog = true" class="d-flex card-bg feedback ma-2 pa-2 cursor-pointer link-no-decor">
        <div v-if="isWide" class="mr-2">Оставить отзыв</div>
        <v-icon icon="mdi-message-outline"></v-icon>
    </div>
    <v-dialog v-model="showFeedbackDialog" :class="isWide ? 'w-66' : 'w-100'">
        <v-card class="w-100 card-bg">
            <v-card-title class="d-flex justify-space-between">
                <span>Оставить отзыв</span>
                <v-icon @click="showFeedbackDialog = false" class="cursor-pointer" color="white" icon="mdi-close-thick"></v-icon>
            </v-card-title>
            <v-card-text class="d-flex flex-column w-100">
                <v-textarea v-model="feedbackText"></v-textarea>
                <div class="w-100 d-flex justify-center align-center">
                    <v-btn @click="sendFeedback" :loading="loadingFeedback">Отправить</v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<style scoped>
</style>
