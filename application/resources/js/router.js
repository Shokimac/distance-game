import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../Vue/components/HomeView.vue';
import PlayerRegist from '../Vue/components/PlayerRegist.vue';
import GameView from '../Vue/components/GameView.vue';

const routes = [
  {
    path: '/',
    component: HomeView,
    name: "home"
  },
  {
    path: "/playerregist",
    component: PlayerRegist,
    name: 'playerregist'
  },
  {
    path: "/game",
    component: GameView,
    name: 'game'
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes: routes
})

export default router;