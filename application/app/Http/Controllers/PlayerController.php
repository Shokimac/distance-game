<?php

namespace App\Http\Controllers;

use App\Domain\Game\Domain\ValueObject\GameId;
use App\Domain\Player\UseCase\FindPlayersUseCase;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    private $findPlayersUseCase;

    public function __construct(FindPlayersUseCase $findPlayersUseCase)
    {
        $this->findPlayersUseCase = $findPlayersUseCase;
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
    public function update(UpdatePlayerRequest $request, Player $player)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        //
    }
}
