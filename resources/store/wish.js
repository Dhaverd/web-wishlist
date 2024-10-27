import {defineStore} from 'pinia';
import axios from "axios";

export const useWishStore = defineStore('wish', {
    state: () => ({
        wishesList: []
    }),
    actions: {
        pushWish(wish){
            this.wishesList.push(wish);
        },
        async getUserWishes(user_id, token){
            let result = null;
            await axios.get(`/api/wish/user_wishes/${user_id.toString()}`,
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        token: token
                    }
                }
            ).then((response)=>{
                result = response.data;
            });
            return result;
        },
        async create(user_id, name, price, url, token){
            let newWish = null;
            await axios.post(`/api/wish/create`,
                {
                    user_id: user_id,
                    name: name,
                    price: price,
                    url: url
                },
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        token: token
                    },
                }
            ).then((response)=>{
                newWish = {status: response.status, statusText: response.statusText, data: response.data};
            });
            return newWish;
        }
    },
})