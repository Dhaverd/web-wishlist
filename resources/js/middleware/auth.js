import {useUserStore} from '../../store/user.js'
import router from '../router.js'

function auth(to, from, next){
    if (to.path === '/'){
        next({path: '/wishlist'});
    }
    if (to.path === '/auth_options' || to.path === '/login' || to.path === '/registration'){
        if (useUserStore().token !== null){
            next({path: '/wishlist'});
        } else {
            next();
        }
    }
    if (useUserStore().user === null && useUserStore().token !== null){
        useUserStore().checkUser().then((result)=>{
            if (result === true){
                next();
            } else {
                next({path: '/auth_options'});
            }
        }).catch((error)=>{
            useUserStore().nullifyUser();
            next({path: '/auth_options'});
        });
    } else if (useUserStore().token === null){
        next({path: '/auth_options'});
    } else {
        next();
    }
}

export default auth;
