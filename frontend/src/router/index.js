import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'home', component: () => import('../views/Home.vue') },
    { path: '/projects/add', name: 'addproject', component: () => import('../views/projects/AddProject.vue') },
    { path: '/projects/edit/:id', name: 'editproject', component: () => import('../views/projects/EditProject.vue'), props: true }
  ]
})

export default router