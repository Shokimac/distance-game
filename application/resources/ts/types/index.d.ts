export type CommonType<T> = T | null;

export interface Game {
	id: string;
	destination_location_id: string;
}

export interface Player {
	id: string;
	game_id: string;
	name: string;
	turn: number;
	draw_location_id: number;
	distance_to_destination: number;
}

export interface Location {
	id: number;
	postal_code: string;
	prefecture: string;
	city: string;
	town: string;
	city_kana: string;
	town_kana: string;
	latitude: string;
	longitude: string;
}
