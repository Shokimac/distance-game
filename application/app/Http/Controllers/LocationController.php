<?php

namespace App\Http\Controllers;

use App\Domain\Location\Domain\ValueObject\LocationId;
use App\Domain\Location\UseCase\FindLocationUseCase;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;

class LocationController extends Controller
{
    private $findLocationUseCase;

    public function __construct(
        FindLocationUseCase $findLocationUseCase
    ) {
        $this->findLocationUseCase = $findLocationUseCase;
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
}
