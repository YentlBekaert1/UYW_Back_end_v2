<?php

namespace App\Http\Controllers;

use App\Models\SubMaterial;
use App\Http\Requests\StoreSubMaterialRequest;
use App\Http\Requests\UpdateSubMaterialRequest;
use App\Http\Resources\SubMaterialResource;
use App\Repositories\SubMaterialsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $submaterials = SubMaterial::query()->paginate($pageSize);
        return SubMaterialResource::collection($submaterials);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubMaterialRequest  $request
     * @return SubMaterialResource | JsonResponse
     */
    public function store(StoreSubMaterialRequest $request, SubMaterialsRepository $repository)
    {
        $created = $repository->create($request->only([
            'name',
            'name_nl',
            'name_en',
            'name_fr',
            'material_id'
        ]));

        return new SubMaterialResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubMaterial  $submaterial
     * @return \Illuminate\Http\Response
     */
    public function show(SubMaterial $submaterial)
    {
        return new SubMaterialResource($submaterial);
    }

       /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function material_submaterials($id)
    {
        $submaterials = SubMaterial::where('material_id', $id)->orderBy('name', 'asc')->get();
        return SubMaterialResource::collection($submaterials);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\SubMaterial  $submaterial
     * @return SubMaterialResource | JsonResponse
     */
    public function update(Request $request, SubMaterial $submaterial, SubMaterialsRepository $repository)
    {
        $subMaterial = $repository->update($submaterial, $request->only([
            'name',
            'name_nl',
            'name_en',
            'name_fr',
            'material_id'
        ]));

        return new SubMaterialResource($subMaterial);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubMaterial  $subMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubMaterial $submaterial, SubMaterialsRepository $repository)
    {
        $deleted = $repository->forceDelete($submaterial);

        return new JsonResponse([
            'data' => $deleted,
        ]);
    }
}
