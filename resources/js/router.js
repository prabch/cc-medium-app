import {createWebHistory, createRouter} from "vue-router";

import home from './pages/Home.vue';
import signup from './pages/Signup.vue';
import signin from './pages/Signin.vue';

import publications from './pages/Publications.vue';
import posts from './pages/Posts.vue';
import newpost from './pages/Newpost.vue';
import postview from './pages/Postview.vue';

import medium from './pages/Medium.vue';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: home
    },
    {
        name: 'signup',
        path: '/signup',
        component: signup
    },
    {
        name: 'signin',
        path: '/signin',
        component: signin
    },
    {
        name: 'publications',
        path: '/publications',
        component: publications
    },
    {
        name: 'posts',
        path: '/posts',
        component: posts
    },
    {
        name: 'newpost',
        path: '/posts/new',
        component: newpost
    },
    {
        name: 'post',
        path: '/post',
        component: postview
    },
    {
        name: 'medium',
        path: '/medium',
        component: medium
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
