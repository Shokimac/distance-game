<?php

namespace App\Http\Controllers;

use App\Domain\Game\Domain\ValueObject\DestinationPostalCode;
use App\Domain\Game\Domain\ValueObject\GameId;
use App\Domain\Game\UseCase\CreateGameUseCase;
use App\Domain\Location\Domain\Entity\LocationEntity;
use App\Domain\Location\Domain\ValueObject\City;
use App\Domain\Location\Domain\ValueObject\CityKana;
use App\Domain\Location\Domain\ValueObject\LocationId;
use App\Domain\Location\Domain\ValueObject\PostalCode;
use App\Domain\Location\Domain\ValueObject\Prefecture;
use App\Domain\Location\Domain\ValueObject\Town;
use App\Domain\Location\Domain\ValueObject\TownKana;
use App\Domain\Location\Domain\Repository\LocationRepositoryInterface;
use App\Domain\Player\Domain\ValueObject\PlayerName;
use App\Domain\Player\Domain\ValueObject\PlayerTurn;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    private $createGameUseCase;
    private $locationRepository;

    public function __construct(
        CreateGameUseCase $createGameUseCase,
        LocationRepositoryInterface $locationRepository,
    ) {
        $this->createGameUseCase = $createGameUseCase;
        $this->locationRepository = $locationRepository;
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
        $pickRandomLocation = $this->locationRepository->findRandomLocation();
        $locationEntity = new LocationEntity(
            locationId: new LocationId($pickRandomLocation->id),
            postalCode: new PostalCode($pickRandomLocation->postal_code),
            prefecture: new Prefecture($pickRandomLocation->prefecture),
            city: new City($pickRandomLocation->city),
            town: new Town($pickRandomLocation->town),
            cityKana: new CityKana($pickRandomLocation->city_kana),
            townKana: new TownKana($pickRandomLocation->town_kana)
        );

        try {
            DB::beginTransaction();
            $gameEntity = $this->createGameUseCase->execute(
                new GameId(uniqid()),
                new DestinationPostalCode($locationEntity->getPostalCode()->value()),
            );

            $registPlayerNames = $request->input('registPlayerNames');

            $players = [];
            foreach ($registPlayerNames as $key => $playerName) {
                $turn = $key + 1;
                $playerEntity = $gameEntity->insertPlayer(
                    playerName: new PlayerName($playerName),
                    playerTurn: new PlayerTurn($turn)
                );

                $players[$turn] = $playerEntity->toArray();
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => '登録に失敗しました。'], 500);
        }

        return response()->json([
            'destinationLocation' => $locationEntity->toArray(),
            'game' => $gameEntity->toArray(),
            'players' => $players,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        //
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
