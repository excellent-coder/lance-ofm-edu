import AuthLayout from '../components/layouts/Auth.vue';
import Signup from '../components/Auth/Signup.vue';
import Login from '../components/Auth/Login.vue';

export const AuthRoutes = [
    {
        path: '/',
        component: AuthLayout,
        children: [

            {
                path: '',
                component: Login,
            },
            {
                path: 'login',
                name: 'login',
                component: Login
            },
            {
                path: 'signup',
                name: 'signup',
                component: Signup
            }
        ]
    }
];
