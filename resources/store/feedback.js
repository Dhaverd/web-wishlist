import {defineStore} from 'pinia'
import axios from "axios";

export const useFeedbackStore = defineStore('feedback', {
    state: () => ({
    }),
    actions: {
        async create(user_id, text){
            let result = null;
            await axios.post(`/api/feedback/create`,
                {
                    user_id: user_id,
                    text: text
                }
            ).then((response)=>{
                result = response;
            });
            return result;
        }
    },
})
