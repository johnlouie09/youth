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
      name: 'contact',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
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
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/poblacion/SanFrancisco.vue'),
    },
    {
      path: '/mountain/perpetual',
      name: 'perpetual',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/mountain/PerpetualHelp.vue'),
    },



    // ADMINS ROUTER
    {
      path: '/admin',
      name: 'admin',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/Admin.vue'),
      children: [
        {
          path: 'dashboard', // Will be /parent/child-a
          component: () => import('../components/adminComponents/Dashboard.vue'),
        },
        {
          path: 'officials', // Will be /parent/child-a
          component: () => import('../components/adminComponents/Officials.vue'),
        },
        {
          path: 'announcements', // Will be /parent/child-a
          component: () => import('../components/adminComponents/Announcements.vue'),
        },
        {
          path: 'achievements', // Will be /parent/child-a
          component: () => import('../components/adminComponents/Achievements.vue'),
        },
        {
          path: 'settings', // Will be /parent/child-a
          component: () => import('../components/adminComponents/Settings.vue'),
        },
        {
          path: 'notices', // Will be /parent/child-a
          component: () => import('../components/adminComponents/Notices.vue'),
        }
      ]
    }
  ],
})

export default router
