import { createRouter, createWebHistory } from 'vue-router'

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
    {
      path: '/:catchAll(.*)',
      name: 'NotFound',
      component: () => import('../components/404.vue'),
    },
    {
      path: '/san-francisco',
      name: 'San Francisco',
      component: () => import('../views/poblacion/SanFrancisco.vue'),
    },
    {
      path: '/barangay',
      name: 'perpetual',
      component: () => import('../views/Barangay.vue'),
    },
  ],
})

export default router