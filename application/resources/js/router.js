import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../Vue/components/HomeView.vue";
import PlayerRegist from "../Vue/components/PlayerRegist.vue";
import GameView from "../Vue/components/GameView.vue";
import GameResult from "../Vue/components/GameResult.vue";

const routes = [
	{
		path: "/",
		component: HomeView,
		name: "home",
	},
	{
		path: "/playerregist",
		component: PlayerRegist,
		name: "playerregist",
	},
	{
		path: "/game/:gameId",
		component: GameView,
		name: "game",
	},
	{
		path: "/result/:gameId",
		component: GameResult,
		name: "result",
	},
];

const router = createRouter({
	history: createWebHistory(),
	routes: routes,
});

export default router;
