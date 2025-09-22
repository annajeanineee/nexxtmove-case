import { createRouter, createWebHistory } from 'vue-router'

import IndexPage from '../pages/IndexPage.vue'
import ShowPage from '../pages/ShowPage.vue'

const routes = [
    { path: '/', name: 'home', component: IndexPage },
    { path: '/listings/:id', name: 'listing.show', component: ShowPage, props: true },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 }
    },
})

export default router


