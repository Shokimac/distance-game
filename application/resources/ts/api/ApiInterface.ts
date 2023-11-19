import { Game, Player, Location } from "../types";

export type ErrorCode = null | "failure" | "Unauthorized" | "NotFound";

type APIResult<T> = Promise<{
    value: T;
    error: ErrorCode;
}>;

export interface ApiInterface {
    createGame: (playerNames: string[]) => APIResult<Game>;
    findGame: (gameId: string) => APIResult<Game>;
    findPlayersByGame: (gameId: string) => APIResult<Player[]>;
    findLocation: (postalCode: string) => APIResult<Location>;
    getLatitudeLongitude: (postalCode: string) => APIResult<Location>;
}
