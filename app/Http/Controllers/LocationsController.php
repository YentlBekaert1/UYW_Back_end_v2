<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationsMapRequest;
use App\Models\Locations;
use App\Http\Requests\StoreLocationsRequest;
use App\Http\Requests\UpdateLocationsRequest;
use App\Http\Resources\LocationsResource;
use App\Repositories\LocationsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $locations = Locations::query()->with("offer")->paginate($pageSize);
        return LocationsResource::collection($locations);
    }

    public function mapbounds(Request $request)
    {
       $locations = Locations::query()->whereBetween('lat', [$request->latSE, $request->latNW])
                        ->whereBetween('lon', [$request->lonSE, $request->lonNW])->with("offer")->whereHas("offer",function($query) use($request){
                            $query->where("status","=",1)
                            ->where("title","LIKE","%{$request->input('query')}%")
                            ->orWhere(function($query) use($request) {
                                $query->whereHas("materials",function($query) use($request){
                                    $query->where("name","LIKE","%{$request->input('query')}%");
                                });
                            })
                            ->orWhere(function($query) use($request) {
                                $query->whereHas("submaterials",function($query) use($request){
                                    $query->where("name","LIKE","%{$request->input('query')}%");
                                });
                            })
                            ->orWhere(function($query) use($request) {
                                $query->whereHas("tags",function($query) use($request){
                                    $query->where("name","LIKE","%{$request->input('query')}%");
                                });
                            })
                            ->orWhere(function($query) use($request) {
                                $query->whereHas("location",function($query) use($request){
                                    $query->where("street","LIKE","%{$request->input('query')}%")
                                          ->orWhere("city","LIKE","%{$request->input('query')}%")
                                          ->orWhere("country","LIKE","%{$request->input('query')}%");
                                });
                            });
                        })->filter($request)->get();

                        // $locations = Locations::query()->whereBetween('lat', [1, 55])
                        // ->whereBetween('lon', [100, 200])->with("offer")->get();
                        //$locations = Locations::query()->with("offer")->get();

        return LocationsResource::collection($locations);
    }

    public function map(Request $request)
    {
       $locations = Locations::query()->with("offer")->filter($request);

       $locations = $locations->whereHas("offer",function($query) use($request){
                            $query->where("status","=",1);
                        })->get();

        return LocationsResource::collection($locations);
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

        return new LocationsResource($created);
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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Locations $location, LocationsRepository $repository)
    {
        $subMaterial = $repository->update($location, $request->only([
            'offers_id',
            'lat',
            'lon',
            'street',
            'number',
            'postal',
            'city',
            'country',
        ]));

        return new LocationsResource($subMaterial);
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

        return new JsonResponse([
            'data' => $deleted,
        ]);
    }
}
