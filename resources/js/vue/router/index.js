import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import UserProfile from "../views/UserProfile.vue";

const routes = [
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/user', component: UserProfile },
    { path: '/:pathMatch(.*)*', redirect: '/login' }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
