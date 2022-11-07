<?php

namespace App\Http\Controllers;

use App\Models\Approach;
use App\Http\Requests\StoreApproachRequest;
use App\Http\Requests\UpdateApproachRequest;
use App\Http\Resources\ApproachResource;
use App\Repositories\ApproachesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApproachController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $approach = Approach::query()->paginate($pageSize);
        return ApproachResource::collection($approach);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApproachRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApproachRequest $request, ApproachesRepository $repository)
    {
        $created = $repository->create($request->only([
            'name',
            'name_nl',
            'name_en',
            'name_fr',
        ]));

        return new ApproachResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Approach  $approach
     * @return \Illuminate\Http\Response
     */
    public function show(Approach $approach)
    {
        return new ApproachResource($approach);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Approach  $approach
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Approach $approach, ApproachesRepository $repository)
    {
        $result = $repository->update($approach, $request->only([
            'name',
            'name_nl',
            'name_en',
            'name_fr',
            'description',
            'description_nl',
            'description_en',
            'description_fr',
            'category_image'
        ]));

        return new ApproachResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Approach  $approach
     * @return \Illuminate\Http\Response
     */
    public function destroy(Approach $approach, ApproachesRepository $repository)
    {
        $deleted = $repository->forceDelete($approach);

        return new JsonResponse([
            'data' => $deleted,
        ]);
    }


    public function web(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $approaches = Approach::query()->paginate($pageSize);
        return view('web.approaches.index', compact('approaches'));
    }

    public function edit(Request $request, Approach $approach)
    {
        return view('web.approaches.edit', compact('approach'));
    }

    public function create()
    {

        return view('web.approaches.create');
    }
}
