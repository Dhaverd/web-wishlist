<template>
    <v-card class="bg-gradient" style="height: 100%">
        <v-card-text class="d-flex justify-center align-center">
            <v-card class="align-center justify-center h-auto w-66 card-bg">
                <v-card-title class="d-flex justify-space-between">
                    <div>
                        <span>Добро пожаловать в </span>
                        <span><a href="/" class="link-no-decor">Wishlist</a></span>
                    </div>
                </v-card-title>
                <v-card-text class="d-flex justify-center align-center h-auto">
                    <ShowWhishlist/>
                </v-card-text>
            </v-card>
        </v-card-text>
    </v-card>
</template>

<script>
import ShowWhishlist from "./PublicWishlist/ShowWhishlist.vue";
export default {
    name: "Public",
    components: {ShowWhishlist}
}
</script>


<style scoped>

.bg-gradient {
    background: linear-gradient(-45deg, #000610, #000f25, #00152f);
    background-size: 100% 100%;
    height: 100vh;
}

</style>
