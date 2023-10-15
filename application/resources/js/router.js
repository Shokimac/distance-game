import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../Vue/components/HomeView.vue"

const routes = [
  {
    path: "/",
    component: HomeView,
    name: "home"
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes: routes
})

export default router;