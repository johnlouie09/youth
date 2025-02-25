import { createRouter, createWebHistory } from 'vue-router'
import SanFrancisco from "../views/poblacion/SanFrancisco.vue"; // Path to the new page


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('../views/Home.vue'),
      alias: ['/home']
    },
    {


      path: '/contact',
      component: () => import('../views/Contact.vue'),
    },
    // {
    //   path: '/SanFrancisco',
    //   name: 'SanFrancisco',
    //   component: SanFrancisco,
    // },


    {
      path: '/san-francisco',
      name: 'San Francisco',
      component: () => import('../views/poblacion/SanFrancisco.vue'),
    },
    {
      path: '/mountain-unit/perpetual',
      name: 'perpetual',

      component: () => import('../views/mountain/PerpetualHelp.vue'),
    },
  ],
})

export default router
