<script>
export default {
    name: "AuthButtons",
    data: ()=>({
        isWide: window.innerWidth >= 800
    })
}
</script>

<template>
    <div class="d-flex flex-column justify-center align-center pa-3" :class="isWide ? 'w-33' : 'w-100'">
        <router-link to="/login" class="w-100 ma-2">
            <v-btn class="w-100">
                Вход
            </v-btn>
        </router-link>
        <router-link to="/registration" class="w-100 ma-2">
            <v-btn class="w-100">
                Регистрация
            </v-btn>
        </router-link>
    </div>
</template>

<style scoped>

</style>
