import { h } from 'vue';
import {
    createRouter,
    createWebHistory,
    createWebHashHistory,
    createMemoryHistory,
    RouterView
}
    from 'vue-router';

const router = new createRouter({
    // history:createWebHashHistory(''),
    history:createWebHistory(),
    routes:[]
});

router.beforeEach((to, from, next) => {
    return next();
});


export default router;
