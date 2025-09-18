import { createRouter, createWebHistory } from 'vue-router';
import PropertiesPage from './pages/PropertiesPage.vue';
import StatisticsPage from './pages/StatisticsPage.vue';

const routes = [
    {
      path: '/',
      name: 'properties',
      component: PropertiesPage
    },{
        path: '/statistics',
        name: 'statistics',
        component: StatisticsPage
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
