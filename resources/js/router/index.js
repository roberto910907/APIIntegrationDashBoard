import Vue from 'vue';
import VueRouter from 'vue-router';

import AdwordsList from '../components/adwords/List';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    base: '/admin',
    routes: [
        {
            path: '/adwords',
            component: AdwordsList,
        },
    ],
});

export default router;
