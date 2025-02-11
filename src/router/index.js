import { createRouter, createWebHistory } from 'vue-router'


import Home from '../views/Home.vue'
import SanFrancisco from "../views/SanFrancisco.vue"; // Path to the new page
m


import Home from '../views/Home.vue'
import SanFrancisco from "../views/SanFrancisco.vue"; // Path to the new page


import Home from '../views/Home.vue'
import SanFrancisco from "../views/SanFrancisco.vue"; // Path to the new page


import Home from '../views/Home.vue'
import SanFrancisco from "../views/SanFrancisco.vue"; // Path to the new page


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


    {


      path: '/SanFrancisco',
      name: 'SanFrancisco',
      component: SanFrancisco,
    },


    // {
    //   path: '/about',
    //   name: 'about',
    //   // route level code-splitting
    //   // this generates a separate chunk (About.[hash].js) for this route
    //   // which is lazy-loaded when the route is visited.
    //   component: () => import('../views/About.vue'),
    // },

  ],
})

export default router
