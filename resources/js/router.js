import {createWebHistory, createRouter} from "vue-router";

import home from './pages/Home.vue';
import register from './pages/Register.vue';
import login from './pages/Login.vue';
import posts from './pages/Posts.vue';

import publish from './components/Publish.vue';
import profile from './components/Profile.vue';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: home
    },
    {
        name: 'register',
        path: '/register',
        component: register
    },
    {
        name: 'login',
        path: '/login',
        component: login
    },
    {
        name: 'posts',
        path: '/posts',
        component: posts
    },
    {
        name: 'publish',
        path: '/publish',
        component: publish
    },
    {
        name: 'profile',
        path: '/profile',
        component: profile
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
