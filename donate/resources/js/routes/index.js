import Vue from 'vue';
import VueRouter from "vue-router";

Vue.use( VueRouter );

const routes = [
    {
        path: '/', name: 'home',
        component: () => import( '../pages/home' )
    },
    {
        path: '/doadores/cadastrar',
        component: () => import( '../pages/donators/create' )
    },
    {
        path: '/doadores/editar/:id', name: 'edit',
        component: () => import( '../pages/donators/edit' )
    },

    {
        path: '/doadores', name: 'list',
        component: () => import( '../pages/donators/list' )
    },

];

export default new VueRouter({
    mode: 'history', routes
});
