<?php

namespace App\Http\Controllers;

use App\Domain\Location\Domain\ValueObject\LocationId;
use App\Domain\Location\Domain\ValueObject\PostalCode;
use App\Domain\Location\UseCase\FindLocationByPostalCodeUseCase;
use App\Domain\Location\UseCase\FindLocationUseCase;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    private $findLocationUseCase;
    private $findLocationByPostalCodeUseCase;

    public function __construct(
        FindLocationUseCase $findLocationUseCase,
        FindLocationByPostalCodeUseCase $findLocationByPostalCodeUseCase
    ) {
        $this->findLocationUseCase = $findLocationUseCase;
        $this->findLocationByPostalCodeUseCase = $findLocationByPostalCodeUseCase;
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
    public function store(StoreLocationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $locationId)
    {
        $locationEntity = $this->findLocationUseCase->execute(new LocationId($locationId));

        return response()->json($locationEntity->toArray(), 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        //
    }

    /**
     * 郵便番号から検索
     */
    public function getByPostalCode(string $postalCode)
    {
        $location = $this->findLocationByPostalCodeUseCase->execute(postalCode: new PostalCode(postalCode: $postalCode));
    }
}
