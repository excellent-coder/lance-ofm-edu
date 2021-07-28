import AppLayout from '../components/layouts/App.vue';
import { RouterView } from 'vue-router';
import { h } from 'vue';

export const AuthRoutes = [
    {
        path: '/',
        component: AppLayout,
        children: [

            {
                path: '',
                component: {render: ()=> h(RouterView)}

            },
            {
                path: '/login',
                name: 'login',
                component: Login
            },
            {
                path: '/signup',
                name: 'signup',
                component: Signup
            }
        ]
    }
];
