import { Game, Player, Location } from "../types";

export type ErrorCode = null | "failure" | "Unauthorized" | "NotFound";

type APIResult<T> = Promise<{
	value: T;
	error: ErrorCode;
}>;

export interface ApiInterface {
	createGame: (playerNames: Player["name"][]) => APIResult<Game>;
	findGame: (gameId: Game["id"]) => APIResult<Game>;
	findPlayersByGame: (gameId: Game["id"]) => APIResult<Player[]>;
	findLocation: (postalCode: Location["postal_code"]) => APIResult<Location>;
	getLocationByPostalCode: (
		postalCode: Location["postal_code"],
	) => APIResult<Location>;
	saveDistanceToDestination: (
		gameId: Game["id"],
		playerId: Player["id"],
		drawLocationId: Location["id"],
		distance: number,
	) => APIResult<boolean>;
	getDrawLocations: (gameId: Game["id"]) => APIResult<Location[]>;
}
