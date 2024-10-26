import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
    state: () => ({
        user: null,
        token: localStorage.getItem('auth_token') || null,
    }),
    // could also be defined as
    // state: () => ({ count: 0 })
    actions: {
        setUser(user) {
            this.user = user;
        },
        setToken(token) {
            this.token = token;
            localStorage.setItem('auth_token', token);
        },
    },
})
