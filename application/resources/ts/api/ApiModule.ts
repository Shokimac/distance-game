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

    async getLocationByPostalCode(postalCode: string) {
        try {
            const { data } = await axios.get<Location>(`/api/locations/postalCode/${postalCode}`);
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

    async saveDistanceToDestination(gameId: Game["id"], playerId: Player["id"], distance: number) {
        try {
            const { data } = await axios.put<boolean>(`/api/games/${gameId}/players/${playerId}`, {
                distance,
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
}
