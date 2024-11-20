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
        async getUserWishes(user_id){
            let result = null;
            await axios.get(`/api/wish/user_wishes/${user_id.toString()}`).then((response)=>{
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
        },
        async remove(id, token){
            await axios.post(`/api/wish/destroy`,
                {
                    id: id
                },
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        token: token
                    },
                }
            ).then((response)=>{
                return response;
            });
        },
        async update(id, user_id, name, price, url, token){
            await axios.post(`/api/wish/update`,
                {
                    id: id,
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
                return response;
            });
        },
        async getWishById(id, token){
            let result = null;
            await axios.get(`/api/wish/by_id/${id.toString()}`,
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
    },
})
