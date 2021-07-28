import AuthLayout from '../components/layouts/Auth.vue';
import Signup from '../components/Auth/Signup.vue';
import Login from '../components/Auth/Login.vue';
import { RouterView } from 'vue-router';
import { h } from 'vue';

export const AuthRoutes = [
    {
        path: '/',
        component: AuthLayout,
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
        ]
    }
];
