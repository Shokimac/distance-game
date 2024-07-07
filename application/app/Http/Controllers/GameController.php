<?php

namespace App\Http\Controllers;

use App\Domain\Game\Domain\ValueObject\GameId;
use App\Domain\Game\UseCase\CreateGameUseCase;
use App\Domain\Game\UseCase\FindGameUseCase;
use App\Domain\Player\Domain\ValueObject\PlayerName;
use App\Domain\Player\Domain\ValueObject\PlayerTurn;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    // ユースケース
    private $createGameUseCase;
    private $findGameUseCase;

    public function __construct(
        CreateGameUseCase $createGameUseCase,
        FindGameUseCase $findGameUseCase,
    ) {
        $this->createGameUseCase = $createGameUseCase;
        $this->findGameUseCase = $findGameUseCase;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreGameRequest $request)
    {
        $registPlayerNames = $request->input('registPlayerNames');

        try {
            DB::beginTransaction();
            $gameEntity = $this->createGameUseCase->execute(
                new GameId(uniqid())
            );

            foreach ($registPlayerNames as $key => $playerName) {
                $turn = $key + 1;
                $gameEntity->insertPlayer(
                    playerName: new PlayerName($playerName),
                    playerTurn: new PlayerTurn($turn)
                );
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return response()->json(['message' => '登録に失敗しました。'], 500);
        }

        return response()->json(
            $gameEntity->toArray(),
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $gameId)
    {
        $gameEntity = $this->findGameUseCase->execute(new GameId(id: $gameId));

        return response()->json($gameEntity->toArray(), 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameRequest $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        //
    }
}
