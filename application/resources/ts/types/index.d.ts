export type CommonType<T> = T | null;

export interface Game {
    id: string;
    destination_postal_code: string;
}

export interface Player {
    id: string;
    game_id: string;
    name: string;
    turn: number;
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
}

export interface EarthCoordinate {
    lat: number;
    lng: number;
}
