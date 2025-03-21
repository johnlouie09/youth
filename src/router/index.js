import { createRouter, createWebHistory } from 'vue-router'
import store from '@/stores';


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('../views/Home.vue')
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/Login.vue'),
      alias: ['/login'],
      beforeEnter: (to, from, next) => {
        const user = store.getters['auth/getUser'];
        if (user)
            next({ name: 'admin-dashboard', params: { barangaySlug: user.barangay.slug } });
        else
            next();
      }
    },
    {
      path: '/contact',
      name: 'contact',
      component: () => import('../views/Contact.vue'),
    },
    {
      path: '/:catchAll(.*)',
      name: 'NotFound',
      component: () => import('../components/404.vue'),
    },
    
    {
      path: '/youth/:barangaySlug',
      name: 'barangay-landingpage',
      component: () => import('../views/Barangay.vue')
    },
    

    // ADMINS ROUTER
    {
      path: '/admin/:barangaySlug',
      name: 'admin',
      component: () => import('../views/Admin.vue'),
      beforeEnter: (to, from, next) => {
        const user = store.getters['auth/getUser'];
        if (user) {
          // Only redirect if the current route's barangaySlug doesn't match the user's barangay slug.
          if (to.params.barangaySlug !== user.barangay.slug) {
            next({ name: 'admin-dashboard', params: { barangaySlug: user.barangay.slug } });
          } else {
            next(); // Already correct, continue navigation.
          }
        } else {
          next({ name: 'login' });
        }
      },      
      children: [
        {
          path: 'dashboard',
          name: 'admin-dashboard',
          component: () => import('../components/adminComponents/Dashboard.vue'),
        },
        {
          path: 'officials',
          name: 'admin-officials',
          component: () => import('../components/adminComponents/Officials.vue')
        },
        {
          path: 'announcements',
          name: 'admin-announcements',
          component: () => import('../components/adminComponents/Announcements.vue'),
        },
        {
          path: 'achievements',
          name: 'admin-achievements',
          component: () => import('../components/adminComponents/Achievements.vue'),
        },
        {
          path: 'settings',
          name: 'admin-settings',
          component: () => import('../components/adminComponents/Settings.vue'),
        },
        {
          path: 'notices',
          name: 'admin-notices',
          component: () => import('../components/adminComponents/Notices.vue'),
        },
        {
          path: 'officials/:officialSlug',
          name: 'admin-edit-official',
          component: () => import('../components/adminComponents/subcomponents/officials/editingOfficial.vue'),
        },
        // DEMO ->
        {
          path: 'demo/message-dialog',
          name: 'demo-message-dialog',
          component: () => import('../components/adminComponents/dialogDemo/MessageDialog.vue')
        },
        {
          path: 'demo/confirm-dialog',
          name: 'demo-confirm-dialog',
          component: () => import('../components/adminComponents/dialogDemo/ConfirmDialog.vue')
        },
        {
          path: 'demo/demoo',
          name: 'demo-demoo',
          component: () => import('../components/adminComponents/dialogDemo/Toast.vue')
        },
        // <-- DEMO
      ]
    }
  ],
})

export default router
