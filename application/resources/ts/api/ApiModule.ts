import axios from "axios";
import { Game, Player, Location, GeoAPIResponse } from "../types";
import { ApiInterface, ErrorCode } from "./ApiInterface";

const API_KEY = import.meta.env.VITE_GOOGLE_API_KEY;

export class ApiModule implements ApiInterface {
    async createGame(playerNames: string[]) {
        try {
            const { data } = await axios.post<Game>("/api/games", {
                registPlayerNames: playerNames,
            });
            if (data) {
                return { value: data, error: null! };
            }
            const error: ErrorCode = "failure";
            return { value: null!, error: error };
        } catch (e) {
            const error: ErrorCode = "failure";
            return { value: null!, error: error };
        }
    }

    async findGame(gameId: string) {
        try {
            const { data } = await axios.get<Game>(`/api/games/${gameId}`);
            if (data) {
                return { value: data, error: null! };
            }
            const error: ErrorCode = "failure";
            return { value: null!, error: error };
        } catch (e) {
            const error: ErrorCode = "failure";
            return { value: null!, error: error };
        }
    }

    async findPlayersByGame(gameId: string) {
        try {
            const { data } = await axios.get<Player[]>(`/api/games/${gameId}/players`);
            if (data) {
                return { value: data, error: null! };
            }
            const error: ErrorCode = "failure";
            return { value: null!, error: error };
        } catch (e) {
            const error: ErrorCode = "failure";
            return { value: null!, error: error };
        }
    }

    async findLocation(locationId: string) {
        try {
            const { data } = await axios.get<Location>(`/api/locations/${locationId}`);
            if (data) {
                return { value: data, error: null! };
            }
            const error: ErrorCode = "failure";
            return { value: null!, error: error };
        } catch (e) {
            const error: ErrorCode = "failure";
            return { value: null!, error: error };
        }
    }

    async getLatitudeLongitude(postalCode: string) {
        try {
            const { data } = await axios.get<GeoAPIResponse>(
                `https://geoapi.heartrails.com/api/json?method=searchByPostal&postal=${postalCode}`,
            );
            if (data) {
                const value = data.response.location[0];
                return { value, error: null! };
            }
            const error: ErrorCode = "failure";
            return { value: null!, error: error };
        } catch (e) {
            const error: ErrorCode = "failure";
            return { value: null!, error: error };
        }
    }
}

interface GeoAPIResponse {
    response: {
        location: [
            {
                city: string;
                city_kana: string;
                town: string;
                town_kana: string;
                x: string;
                y: string;
                prefecture: string;
                postal: string;
            },
        ];
    };
}
