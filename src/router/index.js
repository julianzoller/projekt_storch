import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import video_upload from '../views/video_upload.vue'
import schlagworte_generieren from '../views/schlagworte_generieren.vue'
import text_generieren from '../views/text_generieren.vue'
import social_media from '../views/social_media.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/video_upload',
    name: 'video_upload',
    component: video_upload
  },
  {
    path: '/schlagworte_generieren',
    name: 'schlagworte_generieren',
    component: schlagworte_generieren
  },
  {
    path: '/text_generieren',
    name: 'text_generieren',
    component: text_generieren
  },
  {
    path: '/social_media',
    name: 'social_media',
    component: social_media
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: function () {
      return import(/* webpackChunkName: "about" */ '../views/About.vue')
    }
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
