import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import { fileURLToPath } from "url";

export default defineConfig({
	plugins: [
		vue(),
		laravel({
			input: ["resources/css/app.css", "resources/js/app.js"],
			refresh: true,
		}),
	],
	resolve: {
		alias: {
			"@": fileURLToPath(new URL("./", import.meta.url)),
			// $image: path.resolve('resources/images'),
		},
	},
});
