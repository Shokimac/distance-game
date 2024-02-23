<?php

namespace App\Http\Controllers;

use App\Domain\Game\Domain\ValueObject\GameId;
use App\Domain\Player\Domain\ValueObject\DistanceToDestination;
use App\Domain\Player\Domain\ValueObject\PlayerId;
use App\Domain\Player\UseCase\FindPlayersUseCase;
use App\Domain\Player\UseCase\FindPlayerUseCase;
use App\Domain\Player\UseCase\SavePlayerDistanceUseCase;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    private $findPlayerUseCase;
    private $findPlayersUseCase;
    private $savePlayerDistanceUseCase;

    public function __construct(
        FindPlayersUseCase $findPlayersUseCase,
        FindPlayerUseCase $findPlayerUseCase,
        SavePlayerDistanceUseCase $savePlayerDistanceUseCase
    ) {
        $this->findPlayersUseCase = $findPlayersUseCase;
        $this->findPlayerUseCase = $findPlayerUseCase;
        $this->savePlayerDistanceUseCase = $savePlayerDistanceUseCase;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $gameId)
    {
        $players = $this->findPlayersUseCase->execute(gameId: new GameId($gameId));

        return response()->json($players, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlayerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlayerRequest $request, string $game, string $player)
    {
        $res = $this->savePlayerDistanceUseCase->execute(playerId: new PlayerId(id: $player), distanceToDestination: new DistanceToDestination($request->input('distance')));

        if ($res) {
            return response()->json($res, 200);
        } else {
            return response()->json($res, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        //
    }
}
