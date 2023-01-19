<?php

namespace App\Http\Controllers\web;

use App\Models\Locations;
use App\Http\Requests\StoreLocationsRequest;
use App\Http\Requests\UpdateLocationsRequest;
use App\Http\Resources\LocationsResource;
use App\Repositories\LocationsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mpociot\Reflection\DocBlock\Location;
use App\Http\Controllers\Controller;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function web(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $offer = Locations::query()->with("offer")->paginate($pageSize);
        return view('web.locations.index', compact('offer'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Locations  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Locations $location)
    {
        return new LocationsResource($location);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLocationsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocationsRequest $request, LocationsRepository $repository)
    {
        $created = $repository->create($request->only([
            'offers_id',
            'lat',
            'lon',
            'street',
            'number',
            'postal',
            'city',
            'country',
        ]));

        return redirect()->route('web.locations.index')->with('message', 'Locatie succesvol aangemaakt.');
    }

    public function create()
    {
        return view('web.locations.create');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Locations $location, LocationsRepository $repository)
    {
        $result = $repository->update($location, $request->only([
            'offers_id',
            'lat',
            'lon',
            'street',
            'number',
            'postal',
            'city',
            'country',
        ]));

        return redirect()->route('web.locations.index')->with('message', 'Locatie succesvol gewijzigd.');
    }

    public function edit(Request $request, Locations $location)
    {
        return view('web.locations.edit')->with('location', $location);
    }

    public function delete(Request $request, Locations $location)
    {

        return view('web.locations.delete')->with('location', $location);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Locations $location, LocationsRepository $repository)
    {
        $deleted = $repository->forceDelete($location);
        return redirect()->route('web.locations.index')->with('message', 'Locatie succesvol verwijderd.');
    }
}
